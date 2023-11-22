<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class HomeController extends Controller
{
    // displays dashboard view
    public function home() : View{
        return view('dashboard.index');
    }

}
