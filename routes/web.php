<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminEmploymentTypeController;
use App\Http\Controllers\AdminResearchAreaController;
use App\Http\Controllers\AdminTransvResearchPrioController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompetenceController;
use App\Http\Controllers\CompetenceIframeController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\ExternalContactController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\ResearchAreaController;
use App\Http\Controllers\ResearchAreaIframeController;
use App\Http\Controllers\ResearchController;
use App\Http\Controllers\ResearchIframeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserIframeController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Artisan;
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

// All research area routes
Route::resource('research-area', '\App\Http\Controllers\ResearchAreaController')
    ->parameter('research-area', 'researchArea')
    ->missing(function () {
        return Redirect::route('research-area.index');
    })
    ->except(['index', 'create', 'store', 'destroy'])
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
Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard')->middleware('auth','admin');

Route::get('/admin/personal', [AdminController::class, 'personal'])->name('admin.personal')->middleware('auth','admin');

Route::post('/admin/promote/{user}', [AdminController::class, 'promote'])->name('admin.promote')->middleware('auth','admin');

Route::post('/admin/demote/{user}', [AdminController::class, 'demote'])->name('admin.demote')->middleware('auth','admin');

Route::get('/admin/research', [AdminController::class, 'research'])->name('admin.research')->middleware('auth','admin');

Route::get('/admin/media', [AdminController::class, 'media'])->name('admin.media')->middleware('auth','admin');

Route::get('admin/research-area', [AdminResearchAreaController::class, 'index'])->name('admin.research-area')->middleware('auth','admin');

Route::patch('admin/research-area/{researchArea}/manager', [AdminResearchAreaController::class, 'updateManager'])->name('admin.research-area.updateManager')->middleware('auth','admin');

Route::post('admin/research-area', [AdminResearchAreaController::class, 'create'])->name('admin.research-area.create')->middleware('auth','admin');

Route::delete('admin/research-area{researchArea}/delete', [AdminResearchAreaController::class, 'delete'])->name('admin.research-area.delete')->middleware('auth','admin');

Route::get('admin/employment-type', [AdminEmploymentTypeController::class, 'index'])->name('admin.employment-type.index')->middleware('auth','admin');

Route::get('admin/employment-type/create', [AdminEmploymentTypeController::class, 'create'])->name('admin.employment-type.create')->middleware('auth','admin');

Route::get('admin/employment-type/update-order', [AdminEmploymentTypeController::class, 'updateOrder'])->name('admin.employment-type.updateOrder')->middleware('auth','admin');

Route::post('admin/employment-type/update-order', [AdminEmploymentTypeController::class, 'submitOrder'])->name('admin.employment-type.updateOrder.submit')->middleware('auth','admin');

Route::get('admin/employment-type/{employmentType}', [AdminEmploymentTypeController::class, 'show'])->name('admin.employment-type.show')->middleware('auth','admin');

Route::delete('admin/employment-type/{employmentType}', [AdminEmploymentTypeController::class, 'delete'])->name('admin.employment-type.delete')->middleware('auth','admin');

Route::post('admin/employment-type', [AdminEmploymentTypeController::class, 'store'])->name('admin.employment-type.store')->middleware('auth','admin');

Route::get('admin/employment-type/{employmentType}/edit', [AdminEmploymentTypeController::class, 'edit'])->name('admin.employment-type.edit')->middleware('auth','admin');

Route::patch('admin/employment-type/{employmentType}', [AdminEmploymentTypeController::class, 'update'])->name('admin.employment-type.update')->middleware('auth','admin');

Route::get('admin/transversal-research-prio', [AdminTransvResearchPrioController::class, 'index'])->name('admin.transversal-research-prio.index')->middleware('auth','admin');

Route::get('admin/transversal-research-prio/create', [AdminTransvResearchPrioController::class, 'create'])->name('admin.transversal-research-prio.create')->middleware('auth','admin');

Route::post('admin/transversal-research-prio', [AdminTransvResearchPrioController::class, 'store'])->name('admin.transversal-research-prio.store')->middleware('auth','admin');

Route::get('admin/transversal-research-prio/{prio}', [AdminTransvResearchPrioController::class, 'show'])->name('admin.transversal-research-prio.show')->middleware('auth','admin');

Route::delete('admin/transversal-research-prio/{prio}', [AdminTransvResearchPrioController::class, 'delete'])->name('admin.transversal-research-prio.delete')->middleware('auth','admin');

Route::get('admin/transversal-research-prio/{prio}/edit', [AdminTransvResearchPrioController::class, 'edit'])->name('admin.transversal-research-prio.edit')->middleware('auth','admin');

Route::patch('admin/transversal-research-prio/{prio}', [AdminTransvResearchPrioController::class, 'update'])->name('admin.transversal-research-prio.update')->middleware('auth','admin');

// All inventory routes
Route::prefix('admin/inventory')->group(function() {

    Route::get('/', [AdminController::class, 'inventoryDashboard'])->name('admin.inventory.dashboard')->middleware('auth','admin');

    Route::get('/secure-download/{filePath}', [FileController::class, 'secure'])
        ->where('filePath', '.*')
        ->name('admin.inventory.invoice.download')
        ->middleware('auth','admin');

    Route::resource('computer-type', '\App\Http\Controllers\ComputerTypeController')
        ->except(['show'])
        ->parameter('computer-type', 'computerType')
        ->missing(function () {
            return Redirect::route('comuter-type.index');
        })
        ->middleware('auth','admin');

    Route::resource('peripheral-type', '\App\Http\Controllers\PeripheralTypeController')
        ->except(['show'])
        ->parameter('peripheral-type', 'peripheralType')
        ->missing(function () {
            return Redirect::route('peripheral-type.index');
        })
        ->middleware('auth','admin');

    Route::resource('mobile-device-type', '\App\Http\Controllers\MobileDeviceTypeController')
        ->except(['show'])
        ->parameter('mobile-device-type', 'mobileDeviceType')
        ->missing(function () {
            return Redirect::route('mobile-device-type.index');
        })
        ->middleware('auth','admin');

    Route::resource('manufacturer', '\App\Http\Controllers\ManufacturerController')
        ->except(['show'])
        ->missing(function () {
            return Redirect::route('manufacturer.index');
        })
        ->middleware('auth','admin');

    Route::resource('location', '\App\Http\Controllers\LocationController')
        ->except(['show'])
        ->missing(function () {
            return Redirect::route('location.index');
        })
        ->middleware('auth','admin');

    Route::resource('supplier', '\App\Http\Controllers\SupplierController')
        ->except(['show'])
        ->missing(function () {
            return Redirect::route('supplier.index');
        })
        ->middleware('auth','admin');

    Route::resource('operating-system', '\App\Http\Controllers\OperatingSystemController')
        ->except(['show'])
        ->parameter('operating-system', 'operatingSystem')
        ->missing(function () {
            return Redirect::route('operating-system.index');
        })
        ->middleware('auth','admin');

    Route::resource('keyboard-layout', '\App\Http\Controllers\KeyboardLayoutController')
        ->except(['show'])
        ->parameter('keyboard-layout', 'keyboardLayout')
        ->missing(function () {
            return Redirect::route('keyboard-layout.index');
        })
        ->middleware('auth','admin');

    Route::resource('computer', '\App\Http\Controllers\ComputerController')
        ->missing(function () {
            return Redirect::route('computer.index');
        })
        ->middleware('auth','admin');

    Route::resource('mobile-device', '\App\Http\Controllers\MobileDeviceController')
        ->parameter('mobile-device', 'mobileDevice')
        ->missing(function () {
            return Redirect::route('mobile-device.index');
        })
        ->middleware('auth','admin');

    Route::resource('printer', '\App\Http\Controllers\PrinterController')
        ->missing(function () {
            return Redirect::route('printer.index');
        })
        ->middleware('auth','admin');

    Route::resource('peripheral', '\App\Http\Controllers\PeripheralController')
        ->missing(function () {
            return Redirect::route('peripheral.index');
        })
        ->middleware('auth','admin');

    Route::resource('monitor', '\App\Http\Controllers\MonitorController')
        ->missing(function () {
            return Redirect::route('monitor.index');
        })
        ->middleware('auth','admin');

    Route::resource('software', '\App\Http\Controllers\SoftwareController')
        ->missing(function () {
            return Redirect::route('software.index');
        })
        ->middleware('auth','admin');
});

// All file routes
Route::get('file', [FileController::class, 'index'])->name('file.index')->middleware('auth');

Route::post('file/upload', [FileController::class, 'upload'])->name('file.upload')->middleware('auth');

Route::delete('file/{file}', [FileController::class, 'destroy'])->name('file.destroy')->middleware('auth');

// Iframe routes
Route::prefix('iframe/{language}')->group(function() {
    Route::prefix('user/{user}')->group(function() {
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

        Route::prefix('research')->group(function () {
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

    Route::get('/competence', [CompetenceIframeController::class, 'competence'])
        ->missing(function () {
            return Redirect::route('empty.iframe');
        });

    Route::prefix('research-area/{researchArea}')->group(function () {
        Route::get('/description', [ResearchAreaIframeController::class, 'description'])
            ->missing(function () {
                return Redirect::route('empty.iframe');
            });

        Route::get('/research-focus', [ResearchAreaIframeController::class, 'researchFocus'])
            ->missing(function () {
                return Redirect::route('empty.iframe');
            });

        Route::get('/teaching', [ResearchAreaIframeController::class, 'teaching'])
            ->missing(function () {
                return Redirect::route('empty.iframe');
            });

        Route::get('/support', [ResearchAreaIframeController::class, 'support'])
            ->missing(function () {
                return Redirect::route('empty.iframe');
            });

        Route::prefix('research')->group(function() {
            Route::get('/current', [ResearchAreaIframeController::class, 'currentResearchProjects'])
                ->missing(function () {
                    return Redirect::route('empty.iframe');
                });

            Route::get('/completed', [ResearchAreaIframeController::class, 'completedResearchProjects'])
                ->missing(function () {
                    return Redirect::route('empty.iframe');
                });
        });

        Route::get('/employees', [ResearchAreaIframeController::class, 'employees'])
            ->missing(function () {
                return Redirect::route('empty.iframe');
            });
    });
});

Route::get('iframe', function() {
    return view('empty-iframe');
})->name('empty.iframe');

Route::get('deploy', function() {
    Artisan::call('route:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    Artisan::call('config:cache');
    Artisan::call('route:cache');
    Artisan::call('view:cache');
});
