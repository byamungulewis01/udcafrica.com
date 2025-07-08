<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SettingController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Settings Routes
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/settings', [SettingController::class, 'index']);
    Route::post('/settings/site', [SettingController::class, 'updateSiteSettings']);
    Route::post('/settings/email', [SettingController::class, 'updateEmailSettings']);
    Route::post('/settings/localization', [SettingController::class, 'updateLocalizationSettings']);
});
