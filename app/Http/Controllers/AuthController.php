<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use LdapRecord\Laravel\Auth\ListensForLdapBindFailure;

class AuthController extends Controller
{

    use ListensForLdapBindFailure;

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'uid' => 'required',
            'password' => 'required'
        ]);

        if(Auth::attempt($credentials)) {
            $request->session()->regenerate();
            Log::info("</br>Logged in!</br>");
            return redirect('/');
        }

        return back()->withErrors(['uid' => 'Invalid Credentials'])->onlyInput('shortname');
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
