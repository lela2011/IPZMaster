<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\ExternalContactController;
use App\Http\Controllers\ResearchController;
use App\Http\Controllers\UserController;
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

// Create new media competence
Route::post('/media/create-competence', [MediaController::class, 'createCompetence'])->middleware('auth')->name('competence.create');

// All contact routes
Route::resource('externalContact', '\App\Http\Controllers\ExternalContactController')
    ->missing(function () {
        return Redirect::route('externalContact.index');
    })
    ->except(['show'])
    ->middleware('auth');

// Post request to create external contact
Route::post('/externalContact/createJSON', [ExternalContactController::class, 'createJSON'])->middleware('auth')->name('externalContact.createJSON');

// All administration routes
Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard')->middleware('admin');

Route::get('/admin/personal', [AdminController::class, 'personal'])->name('admin.personal')->middleware('admin');

Route::post('/admin/promote/{user}', [AdminController::class, 'promote'])->name('admin.promote')->middleware('admin');

Route::post('/admin/demote/{user}', [AdminController::class, 'demote'])->name('admin.demote')->middleware('admin');

Route::get('/admin/research', [AdminController::class, 'research'])->name('admin.research')->middleware('admin');
