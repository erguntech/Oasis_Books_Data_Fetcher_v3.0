<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ApiSettingsController;
use App\Http\Controllers\XMLFetchController;
use App\Http\Controllers\XMLBooksController;
use App\Http\Controllers\DataUpdaterController;

// DashboardController Start
Route::get('/', [DashboardController::class, 'index'])->name('Dashboards.Administrators');
// DashboardController End

// ApiSettingsController Start
Route::get('/apisettings', [ApiSettingsController::class, 'index'])->name('ApiSettings.Index');
Route::post('/apisettings', [ApiSettingsController::class, 'update'])->name('ApiSettings.Update');
Route::post('/ajax/apitest', [ApiSettingsController::class, 'apiTest'])->name('ApiSettings.APITest');
// ApiSettingsController End

// XMLFetchController Start
Route::get('/xmlfetch', [XMLFetchController::class, 'index'])->name('XMLFetch.Index');
Route::post('/ajax/xmlfetch', [XMLFetchController::class, 'xmlFetch'])->name('XMLFetch.XMLFetch');
// XMLFetchController End

// XMLBooksController Start
Route::get('/xmlbooks', [XMLBooksController::class, 'index'])->name('XMLBooks.Index');
// XMLBooksController End

// DataUpdaterController Start
Route::get('/dataupdater', [DataUpdaterController::class, 'index'])->name('DataUpdater.Index');
Route::post('/ajax/dataupdater', [DataUpdaterController::class, 'update'])->name('DataUpdater.update');
// DataUpdaterController End
