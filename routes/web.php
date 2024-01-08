<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompetenceController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\ExternalContactController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\ResearchController;
use App\Http\Controllers\ResearchIframeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserIframeController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

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

// All research routes
Route::resource('research', '\App\Http\Controllers\ResearchController')
    ->parameter('research', 'researchProject')
    ->missing(function () {
        return Redirect::route('research.index');
    })
    ->middleware('auth');

// All media competence routes
Route::resource('media', '\App\Http\Controllers\MediaController')
    ->parameter('media', 'user')
    ->missing(function () {
        return Redirect::route('media.show', Auth::user()->uid);
    })
    ->middleware('auth');

// All contact routes
Route::resource('externalContact', '\App\Http\Controllers\ExternalContactController')
    ->missing(function () {
        return Redirect::route('externalContact.index');
    })
    ->except(['show'])
    ->middleware('auth');

// Post request to create external contact
Route::post('/externalContact/createJSON', [ExternalContactController::class, 'createJSON'])->middleware('auth')->name('externalContact.createJSON');

// All competence routes
Route::resource('competence', '\App\Http\Controllers\CompetenceController')
    ->missing(function () {
        return Redirect::route('competence.index');
    })
    ->except(['show', 'create', 'edit'])
    ->middleware('auth');

// Create new media competence
Route::post('/competence/createJSON', [CompetenceController::class, 'createJSON'])->middleware('auth')->name('competence.createJSON');

// All administration routes
Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard')->middleware('admin');

Route::get('/admin/personal', [AdminController::class, 'personal'])->name('admin.personal')->middleware('admin');

Route::post('/admin/promote/{user}', [AdminController::class, 'promote'])->name('admin.promote')->middleware('admin');

Route::post('/admin/demote/{user}', [AdminController::class, 'demote'])->name('admin.demote')->middleware('admin');

Route::get('/admin/research', [AdminController::class, 'research'])->name('admin.research')->middleware('admin');

Route::get('/admin/media', [AdminController::class, 'media'])->name('admin.media')->middleware('admin');

// All file routes
Route::get('file', [FileController::class, 'index'])->name('file.index')->middleware('auth');

Route::post('file/upload', [FileController::class, 'upload'])->name('file.upload')->middleware('auth');

Route::delete('file/{file}', [FileController::class, 'destroy'])->name('file.destroy')->middleware('auth');

// Iframe routes
Route::prefix('iframe/{language}')->group(function() {
    Route::prefix('users/{user}')->group(function() {
        Route::get('/cv', [UserIframeController::class, 'cv'])
            ->missing(function () {
                return Redirect::route('empty.iframe');
            });
        Route::get('/research-focus', [UserIframeController::class, 'researchFocus'])
            ->missing(function () {
                return Redirect::route('empty.iframe');
            });

        Route::get('/research-areas', [UserIframeController::class, 'researchAreas'])
            ->missing(function () {
                return Redirect::route('empty.iframe');
            });

        Route::get('/transversal-research-priorities', [UserIframeController::class, 'transversalResearchPrios'])
            ->missing(function () {
                return Redirect::route('empty.iframe');
            });

        Route::prefix('research-projects')->group(function () {
            Route::get('/current', [UserIframeController::class, 'currentResearchProjects'])
            ->missing(function () {
                return Redirect::route('empty.iframe');
            });

            Route::get('/completed', [UserIframeController::class, 'completedResearchProjects'])
                ->missing(function () {
                    return Redirect::route('empty.iframe');
                });
        });

        Route::get('orcid', [UserIframeController::class, 'orcid'])
            ->missing(function () {
                return Redirect::route('empty.iframe');
            });

    });

    Route::prefix('research')->group(function() {
        Route::get('/current', [ResearchIframeController::class, 'currentResearchProjects'])
            ->missing(function () {
                return Redirect::route('empty.iframe');
            });

        Route::get('/completed', [ResearchIframeController::class, 'completedResearchProjects'])
            ->missing(function () {
                return Redirect::route('empty.iframe');
            });
    });
});

Route::get('iframe', function() {
    return view('empty-iframe');
})->name('empty.iframe');
