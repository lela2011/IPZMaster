<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\ResearchController;
use App\Http\Controllers\UsersController;
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

// Display personal data in form to be edited. Only accessible when logged in
Route::get('/personal', [UsersController::class, 'show'])->middleware('auth')->name('personal');

// Post request to update personal data in DB
Route::post('/personal', [UsersController::class, 'update'])->middleware('auth')->name('personal.update');

// All research routes
Route::resource('research', '\App\Http\Controllers\ResearchController')
    ->missing(function () {
        return Redirect::route('research.index');
    })
    ->middleware('auth');

// Post request to create external contact
Route::post('/research/create-contact', [ResearchController::class, 'createContact'])->middleware('auth')->name('contact.create');

// Display current media competence preferences
Route::get('/media', [MediaController::class, 'index'])->middleware('auth')->name('media');

// Submit media competences update
Route::post('/media', [MediaController::class, 'update'])->middleware('auth')->name('media.update');

// Create new media competence
Route::post('/media/create-competence', [MediaController::class, 'createCompetence'])->middleware('auth')->name('competence.create');
