# Laravel Documentation
## Pages
### Routes
Laravel uses routes to handle navigation inside the web application.To add a route, navigate to `./routes/web.php`. The file should look something like this:
```php
// Home Route
Route::get('/', [HomeController::class, 'home'])->name('home');

// Post request to validate Login-Credentials against LDAP-Database
Route::post('/authenticate', [AuthController::class, 'authenticate'])->name('auth');

// Post request to log out user. Only accessible when logged in
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// All personal data routes
Route::resource('personal', '\App\Http\Controllers\UserController')
    ->parameter('personal', 'user')
    ->missing(function () {
        return Redirect::route('personal.show', Auth::user()->uid);
    })
    ->except(['index'])
    ->middleware('auth');

...

Route::delete('file/{file}', [FileController::class, 'destroy'])->name('file.destroy')->middleware('auth');
```
You can create multiple types of Routes. The most common options are `Route::get();`, `Route::post();`, `Route::put();`, `Route::patch();`, `Route::delete();` and `Route::resource();`.

The use of them is fairly self-explainatory. `Route::get()` is used to create a new GET-Request, `Route::post()` for a new POST-Request and so on.

All of the REST-Requests take in two parameters. The first one is the name of the route. For example `/authenticate` can be found at `https://ipz.uzh.ch/apps/IPZMaster/authenticate`. The second parameter is an array. The first item being a Controller class (more on that later), the second one is the function name that should be called in the controller class.

In addition to that you can define additional settings. For example `->middleware('')` lets you define if users should be allowed to access the page. For example `->middleware('auth')` only allows authenticated users, while `->middleware('admin')` only allows users with `adminLevel > 0` to access the page.

Each Page should also have a `->name('example.name')` defined. This can be used to reference the page elsewhere in the application by calling `route('example.name')`. It is advised to only use named routes to ensure that correct urls are automatically generated.

If you want to manage an entire model it is best practice to use `Route::resouorce()`. This route takes two parameters. The first one being the name of the routes that will be generated. E.g. `Route::resource('personal', ...)` will by default create the routes `https://ipz.uzh.ch/apps/IPZMaster/personal`, `https://ipz.uzh.ch/apps/IPZMaster/personal/{personal}`, `https://ipz.uzh.ch/apps/IPZMaster/personal/{personal}/edit` and so on. The second paramter is the global path to the controller.

The value in the curly braces is a unique identifier, for example the users `shortname`. It will be provided as a parameter to all controller functions that link to a route with such a parameter. To change it's name you can for example add `->parameter('personal', 'user')`. This changes the name of the parameter from `personal` to `user`.

You can also define what should happen when a model can't be found by providing `->missing(function() {})`.

If you want to exclude certain routes by providing `->except([])`.

More on resource routes can be found [here](https://laravel.com/docs/10.x/controllers#resource-controllers).

### Controllers
Controllers are classes that handle the displaying and validation logic in the application. Each "branch" (like user, media, research) and so on should have their own controller.

Controllers are created through the command `$ php artisan make:Controller ControllerName` and can be found under `./app/Http/Controllers`. A controller looks something like this:
```php
class HomeController extends Controller
{
    // displays dashboard view
    public function home(Request $request) : View{

        return view('dashboard.index');
    }

}
```
or
```php
class AuthController extends Controller
{

    public function authenticate(Request $request)
    {

        // validate if input fields are empty
        $credentials = $request->validate([
            'uid' => 'required',
            'password' => 'required'
        ],
        [
            'uid.required' => 'Shortname may not be empty', // set custom error message for empty shortname
            'password.required' => 'Password may not be empty' // set custom error message for empty password
        ]);

        if(Auth::attempt($credentials)) { // validate credentials against LDAP-Record
            // regenerate session with updated authentication information
            $request->session()->regenerate();
            // return to homepage
            return redirect('/');
        }
        // if authentication failed, return back to login form and display descrete error message under shortname field
        return back()->withErrors(['uid' => 'Shortname or password do not match'])->onlyInput('uid');
    }

    public function logout(Request $request) {
        // log out user
        Auth::logout();
        // remove authentication info from session
        $request->session()->invalidate();
        // regenerate csrf-token
        $request->session()->regenerateToken();
        // redirect to homepage
        return redirect('/');
    }
}
```
The most important return values are `return view("")`, `return redirect()->route("")` and `return back()`

`return view("user.dashboard")` is used to display a php page to the user. The functions first argument is used to define the view file. It follows the following pattern: `folder.filename_without_type`. Additionally a second argument (an array) can be defined. This array consists of key value pairs, while the key is the variable name accessible in the views php script and the value is the php variable in the controller function. For example:
```php
$user = Auth::user()
return view("user.dashboard", [
    'userName' => $user->name
])
```
Inside the php page `$userName` can be accessed.

`return redirect()->route("")` is used to redirect the user to a specific route with the name as entered in the `route("")` function. For example to redirect to the route with the name `personal.index` you would call `return redirect()->route("personal.index")`.

`return back()` simply navigates back to the last page.

Each navigation can be modified with additional parameters. For example by adding `->with()` you can return custom values like a message or an error message. `->with()` takes two arguments. The first one being the name of the variable that should be accessible inside the session. The second one being it's value. For example `->with("error","This is an error")` creates an error variable in the session with the value "This is an error". It can be accessed by calling `session('error')`. Inside a view.

An additional feature that is commonly used is form data validation. This can either be done simply by calling `->validate([],[])` on the post request. The first array is a set of rules provided as key value pairs. The key being the form data name and the value being a string of predefined rules. The second array is a list of custom error messages. It is optional. An example is visible here:
```php
$formInput = $request->validate([
    'competence' => 'required|string|unique:competences,name'
],[
    'competence.unique' => 'The competence already exists.',
    'competence.required' => 'Please enter a competence.'
]);
```
All validation information can be found [here](https://laravel.com/docs/10.x/validation#quick-writing-the-validation-logic).

Another form of validation is the use of requests. They can be created using the command `$ php artisan make:request RequestName`. You simply replace the standard `(Request $request)` part of the controller route by `(RequestName $request)` and validation will be handled by the custom Request. It looks something like this:
```php
class PersonalDataRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // allows form submits from every user
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // sets validation rules for form data
        return [
            'orcid' => ['nullable', new OrcidValidation],
            'website' => 'nullable|url',
            'cv_english' => 'nullable',
            'cv_german' => 'nullable',
            'research_focus_english' => 'nullable',
            'research_focus_german' => 'nullable',
            'research_areas' => 'nullable',
            'transv_research_prios' => 'nullable'
        ];
    }

    public function messages(): array
    {
        return [
            'website.url' => 'The website must be a valid URL.',
        ];
    }

    protected function prepareForValidation()
    {
        // merges the array into a hyphen-separated string
        $temp_orcid = implode('-', $this->orcid);
        $temp_orcid = $temp_orcid === "---" ? '' : $temp_orcid;

        // merges the correction with the
        $this->merge([
            'research_areas' => filterEmptyArray($this->research_areas),
            'orcid' => $temp_orcid,
            'research_areas' => $this->research_areas ?? [],
            'transv_research_prios' => $this->transv_research_prios ?? []
        ]);
    }
}
```
More information can be found [here](https://laravel.com/docs/10.x/validation#form-request-validation).

### Blade Pages

Laravel works with blade templates. A blade template can be created by adding `.blade.php` to the desired file name. Blade simplifies the use of php code inside the web page. By typing `{{  }}` inside of the html code you can access php variables. In addition to that there are multiple blade directives which simplify the use of php a lot. An overview can be found [here](https://laravel.com/docs/10.x/blade#blade-directives).

The two most used are `@if @else @endif` and `foreach() @endforeach`. Their use is self-explainatory and is very well documented in the liked documentation

A very commonly used feature for forms is also `{{ old() }}`. This function is used to repopulate forms upon failed validation or when first accessing an edit page. `old()` takes two parameters. The first one being the post-requests form data key. The second one being a default value. This is particularly useful if you are working with edit pages where already defined data should be filled into the form. For example for the email field with the id 'mail' you would type `old("mail", $DBmail)`

### Blade Components

Laravel provides the ability to create partial views that can be used elsewhere. These views are called components and can be found in `resources/views/components`. They are created just like pages are. The two most common types of components are either reusable views like flash-messages or surrounding views like a default template. Reusable views work the same as normal pages and can be added to other views by adding an html tag with `x-` in front of it like so: `<x-customComponent></x-customComponent>`.

Templates work by building a view and adding something called a slot into them. The default page layout component looks like this:
```php
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-template="st04">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="theme-color" content="#ffffff">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>IPZ Master</title>
        <link rel="icon" type="image/x-icon" href="{{asset('images/favicon.ico')}}">
        <link rel="stylesheet" href="https://www.uzh.ch/static/magnolia/assets/css/main.css"/>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/css/selectize.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>
        <script src="//unpkg.com/alpinejs" defer></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/js/selectize.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        <x-head.tinymce-config/>

        <link rel="stylesheet" href="{{asset('css/custom.css')}}">
    </head>
    <body class="template-st04">
        <x-header/>
        <main>
            {{$slot}}
        </main>
        <x-footer/>
    </body>
</html>
```
It can now be used like this:
```html
<x-layout>
    <h1>
        Hello World
    </h1>
    <p>
        This is a paragraph
    </p>
</x-layout>
```

## Data
### Database Migrations
Database tables can be created by defining database migrations using the command `$ php artisan make:migration migrationName`. They can be found under `database/migrations` A migration file looks like this:
```php
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // defines the table structure of Users-Table
        Schema::create('users', function (Blueprint $table) {
            $table->string('uid')->primary();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('orcid')->nullable();
            $table->string('website')->nullable();
            $table->longText('cv_english')->nullable();
            $table->longText('cv_german')->nullable();
            $table->longText('research_focus_english')->nullable();
            $table->longText('research_focus_german')->nullable();
            $table->boolean('media_mail')->default(false);
            $table->boolean('media_phone')->default(false);
            $table->boolean('media_secretariat')->default(false);
            $table->string('password')->nullable();
            $table->integer('adminLevel')->default(0);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // drops table on migration refresh
        Schema::dropIfExists('users');
    }
};
```
A pivot table's migration may look like this:
```php
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_transv_research_prio', function (Blueprint $table) {
            $table->string('user_id');
            $table->string('transv_research_prio_id');

            $table->foreign('user_id')->references('uid')->on('users')->onDelete('cascade');
            $table->foreign('transv_research_prio_id')->references('id')->on('transv_research_prios')->onDelete('cascade');

            $table->primary(['user_id', 'transv_research_prio_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_transv_research_prio');
    }
};
```
Additional information can be found [here](https://laravel.com/docs/10.x/migrations).

### Models
Models are used to define data structures used in the php application. The can be created by calling the command `$ php artisan make:model ModelName`. The can be found under `app/Models`. A model may look like this.
```php
class User extends Authenticatable implements LdapAuthenticatable
{
    use Notifiable, AuthenticatesWithLdap;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'uid',
        'password',
        'first_name',
        'last_name',
        'orcid',
        'website',
        'cv_english',
        'cv_german',
        'research_focus_english',
        'research_focus_german',
        'media_mail',
        'media_phone',
        'media_secretariat',
        'adminLevel'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'research_areas' => 'array',
        'media_mail' => 'boolean',
        'media_phone' => 'boolean',
        'media_secretariat' => 'boolean',
    ];

    //Sets id-key to 'uid' and ensures that it's not auto-incremented
    protected $primaryKey = "uid";
    public $incrementing = false;

    // sets relation between competence and user
    public function competences() : BelongsToMany {
        return $this->belongsToMany(Competence::class, 'user_competence', 'user_id', 'competence_id');
    }

    // sets relation between research project and user
    public function projects() : BelongsToMany {
        return $this->belongsToMany(ResearchProject::class, 'user_research_project', 'user_id', 'research_project_id')->withPivot('role');
    }

    // sets relation between project contacts and user
    public function projectContacts() : BelongsToMany {
        return $this->belongsToMany(ResearchProject::class, 'research_project_contact', 'user_id', 'research_project_id');
    }

    // sets relation between research area and user
    public function researchAreas() : BelongsToMany {
        return $this->belongsToMany(ResearchArea::class, 'user_research_area', 'user_id', 'research_area_id');
    }

    // sets relation between research priority and user
    public function transversalResearchPriorities() : BelongsToMany {
        return $this->belongsToMany(TransversalReserachPrio::class, 'user_transv_research_prio', 'user_id', 'transv_research_prio_id');
    }

    // sets relation between user and file
    public function files(): HasMany {
        return $this->hasMany(File::class, 'user_id', 'uid');
    }
}
```
The model has the same attributes as the database table with the plural model name. So the model `User` corresponds to the DB-table `users` and has the attributes `uid`, `first_name`, `last_name`, ... the can be accessed by calling
```php
$user = User::get("asdfdf")
$firstName = $user->first_name
```
It is important to mention that mass-assignment of data is only possible to those table columns that are listed in `$fillable`

Models are also used to query the database by calling for example `User::all()`, `Model::where('uid', 'abdfad')` and so on.

In adition to that the model is used to define table relationships. All necessary information can be found [here](https://laravel.com/docs/10.x/eloquent-relationships)

All additional model and database information is well documented [here](https://laravel.com/docs/10.x/eloquent).

## Publication
Upload the project to a folder called IPZMaster in Plesks root directory.

In `.env` the `APP_URL` must be changed to `https://www.ipz.uzh.ch/apps/IPZMaster` and in `./config/app` the `APP_URL` must also be changed to `https://www.ipz.uzh.ch/apps/IPZMaster`.

Now you can switch to the composer section of plesk and install and update all the packages.

After that the entire `IPZMaster` folder must be moved to the servers rood directory.

By connecting to the server via ssh, the following 4 commands must be executed from the root directory
```bash
$ cd httpdocs/apps
$ ln -s ../../IPZMaster/public IPZMaster
$ cd ../../IPZMaster/public
$ ln -s ../storage/app/public storage
```

Now the web application should be up and running.
