<?php

use App\Http\Controllers\BlogCategoryController;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectCategoryController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\PartnershipController;
use App\Http\Controllers\ContactRequestController;
use App\Http\Controllers\WebsiteController;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

Route::get('/', [WebsiteController::class, 'home'])->name('home');
Route::get('/services', [WebsiteController::class, 'services'])->name('services');
Route::get('/projects', [WebsiteController::class, 'projects'])->name('projects');
Route::get('/about', [WebsiteController::class, 'about'])->name('about');
Route::get('/contact', [WebsiteController::class, 'contact'])->name('contact');
Route::get('/blog', [WebsiteController::class, 'blog'])->name('blog');

Route::post('/contact', [ContactRequestController::class, 'store'])->name('contact.store');



Route::middleware(['auth', 'verified', 'track-last-login', 'active-user'])->prefix(
    'admin'
)->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::middleware('user-access:super_admin,admin')->group(function () {
        Route::resource('users', UserController::class);

        Route::resource('blog-categories', BlogCategoryController::class);
        Route::post('blog-categories/reorder', [BlogCategoryController::class, 'reorder'])->name('blog-categories.reorder');

        Route::resource('blogs', BlogController::class);
        Route::post('blogs/reorder', [BlogController::class, 'reorder'])->name('blogs.reorder');

        Route::resource('projects', ProjectController::class);
        Route::post('projects/reorder', [ProjectController::class, 'reorder'])->name('projects.reorder');

        Route::resource('project-categories', ProjectCategoryController::class);
        Route::post('project-categories/reorder', [ProjectCategoryController::class, 'reorder'])->name('project-categories.reorder');

        Route::controller(TeamController::class)->prefix('teams')->name('teams.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/', 'store')->name('store');
            Route::post('/{team}', 'update')->name('update');
            Route::delete('/{team}', 'destroy')->name('destroy');
            Route::put('reorder', 'reorder')->name('reorder');
        });

        Route::controller(ServicesController::class)->prefix('services')->name('services.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/', 'store')->name('store');
            Route::post('/{service}', 'update')->name('update');
            Route::delete('/{service}', 'destroy')->name('destroy');
            Route::put('reorder', 'reorder')->name('reorder');
        });
        Route::controller(PartnershipController::class)->prefix('partnerships')->name('partnerships.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/', 'store')->name('store');
            Route::post('/{partnership}', 'update')->name('update');
            Route::delete('/{partnership}', 'destroy')->name('destroy');
            Route::put('reorder', 'reorder')->name('reorder');
        });

        Route::resource('news', NewsController::class);
    });

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Settings Routes
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings/site', [SettingController::class, 'updateSiteSettings'])->name('settings.site.update');
    Route::post('/settings/email', [SettingController::class, 'updateEmailSettings'])->name('settings.email.update');
    Route::post('/settings/localization', [SettingController::class, 'updateLocalizationSettings'])->name('settings.localization.update');

    // Contact Form Routes



    // Contact Requests Management Routes (Protected)
    Route::middleware(['auth'])->group(function () {
        Route::get('/contact-requests', [ContactRequestController::class, 'index'])->name('contact-requests.index');
        Route::patch('/contact-requests/{contactRequest}/status', [ContactRequestController::class, 'updateStatus'])->name('contact-requests.status.update');
        Route::delete('/contact-requests/{contactRequest}', [ContactRequestController::class, 'destroy'])->name('contact-requests.destroy');
    });

});

Route::get('/sitemap.xml', function () {
    $sitemap = Sitemap::create()
        ->add(Url::create('/'))
        ->add(Url::create('/services'))
        ->add(Url::create('/all-products'))
        ->add(Url::create('/about'))
        ->add(Url::create('/contact'));
        // ->add(Url::create('/blogs'));
    // Add more URLs as needed, e.g., dynamic blog posts, products, etc.
    return $sitemap->toResponse(request());
});

require __DIR__ . '/auth.php';
