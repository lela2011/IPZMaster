<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use LdapRecord\Laravel\Auth\ListensForLdapBindFailure;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    // set handling of exceptions when LDAP-Bind fails
    use ListensForLdapBindFailure;

    // handles exceptions when LDAP-Bind fails
    protected function handleLdapBindError(string $message, string $code = null): void
    {
        // defines message that is displayed when connection with authentication server fails
        throw ValidationException::withMessages([
            'serverError' => "Couldn't connect to authentication server. Please try again later. If the error persists please contact support."
        ]);
    }

    public function __construct() {
        $this->listenForLdapBindFailure();
    }

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
