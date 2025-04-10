<?php

use App\Http\Controllers\Admin\LandingPageController;
use App\Http\Controllers\AdvertisementController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\Admin\AdvertisementCrudController;
use App\View\Components\Header;
use Illuminate\Support\Facades\Route;

// Public routes
Route::view('/', 'welcome')->name('home');


// Authenticated routes
Route::middleware(['auth'])->group(function () {
    Route::view('dashboard', 'dashboard')->middleware('verified')->name('dashboard');
    Route::view('profile', 'profile')->name('profile');


    // Contract routes
    Route::prefix('contracts')->group(function () {
        Route::get('/', [ContractController::class, 'index'])->name('contracts.index');
        Route::get('upload', [ContractController::class, 'showUploadForm'])->name('contracts.showUploadForm');
        Route::post('upload', [ContractController::class, 'upload'])->name('contracts.upload');
        Route::post('export-pdf/{id}', [ContractController::class, 'exportPdf'])->name('export-pdf');
    });


    // Advertisement routes
    Route::prefix('advertisements')->group(function () {
        Route::get('/', [AdvertisementController::class, 'index'])->name('advertisements.index');
        Route::get('create', [AdvertisementController::class, 'create'])->name('advertisements.create');
        Route::post('/', [AdvertisementController::class, 'store'])->name('advertisements.store');
        Route::get('{advertisement}', [AdvertisementController::class, 'show'])->name('advertisements.show');

    });


    // Rental routes
    Route::get('calendar', function () {
        return view('calendar');
    })->name('calendar');



    // Advertisement CSV upload routes
    Route::prefix('advertisement')->group(function () {
        Route::get('upload-csv', [AdvertisementCrudController::class, 'showUploadForm'])->name('crud.advertisement.uploadCsvForm');
        Route::post('upload-csv', [AdvertisementCrudController::class, 'uploadCsv'])->name('crud.advertisement.uploadCsv');
    });
});


// Landing page route
Route::get('/landing-page/{url}', [LandingPageController::class, 'show']);


// Locale change route
Route::middleware('web')->group(function () {
    Route::get('change-locale/{locale}', [Header::class, 'changeLocale'])->name('change-locale');
});

require __DIR__ . '/auth.php';
