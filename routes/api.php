<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\Api\WebsiteController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Website Routes
Route::get('/projects', [WebsiteController::class, 'getProjects']);
Route::get('/featured-projects', [WebsiteController::class, 'getFeaturedProjects']);
Route::get('/featured-blogs', [WebsiteController::class, 'getFeaturedBlogs']);
Route::get('/blogs', [WebsiteController::class, 'getAllBlogs']);

// Settings Routes
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/settings', [SettingController::class, 'index']);
    Route::post('/settings/site', [SettingController::class, 'updateSiteSettings']);
    Route::post('/settings/email', [SettingController::class, 'updateEmailSettings']);
    Route::post('/settings/localization', [SettingController::class, 'updateLocalizationSettings']);
});
