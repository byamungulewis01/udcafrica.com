<?php

use App\Models\Blog;
use Inertia\Inertia;
use App\Models\Project;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\WebsiteController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\PartnershipController;
use App\Http\Controllers\BlogCategoryController;
use App\Http\Controllers\ContactRequestController;
use App\Http\Controllers\ProjectCategoryController;

Route::get('/', [WebsiteController::class, 'home'])->name('home');
Route::get('/services', [WebsiteController::class, 'services'])->name('services');
Route::get('/projects', [WebsiteController::class, 'projects'])->name('projects');
Route::get('/projects/{slug}', [WebsiteController::class, 'projectDetails'])->name('project.details');
Route::get('/about', [WebsiteController::class, 'about'])->name('about');
Route::get('/contact', [WebsiteController::class, 'contact'])->name('contact');
Route::get('/blog', [WebsiteController::class, 'blog'])->name('blog');
Route::get('/blog/{slug}', [WebsiteController::class, 'blogDetails'])->name('blog.details');
Route::get('/careers/youtube-presenter', [WebsiteController::class, 'youtubePresenter'])->name('careers.youtube-presenter');

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
        ->add(Url::create('/about'))
        ->add(Url::create('/contact'))
        ->add(Url::create('/blog'))
        ->add(Url::create('/projects'));

    // Add more URLs as needed, e.g., dynamic blog posts, products, etc.
    $blogs = Blog::where('is_published', true)->get();
    foreach ($blogs as $blog) {
        $sitemap->add(Url::create('/blog/' . $blog->slug));
    }
    $projects = Project::where('is_published', true)->get();
    foreach ($projects as $project) {
        $sitemap->add(Url::create('/projects/' . $project->slug));
    }
    return $sitemap->toResponse(request());
});

// Catch-all route for 404 Not Found (must be last)
Route::fallback(function () {
    return Inertia::render('Errors/NotFound');
});

require __DIR__ . '/auth.php';
