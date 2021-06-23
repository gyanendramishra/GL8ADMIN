<?php

use App\Http\Controllers\Admin\Auth\ResetPasswordController;
use App\Http\Controllers\Admin\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\EnquiryController;
use App\Http\Controllers\Admin\ImagesController;
use App\Http\Controllers\Admin\ReportsController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\PasswordController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\EmailTemplateController;

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Frontend

Route::get('/', [HomeController::class, 'index'])
    ->name('home')
    ->middleware('guest');

// Admin

Route::group(["prefix" => "admin", "as" => "admin."], function () {

    // Auth routes
    Route::get("/", function () {
        return redirect()->route("admin.login");
    });
    // Login routes
    Route::get('login', [LoginController::class, 'showLoginForm'])
        ->name('login')
        ->middleware('guest');
    Route::post('login', [LoginController::class, 'login'])
        ->name('login.attempt')
        ->middleware('guest');

    // Forgot password routes
    Route::get('forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])
        ->name('password.request')
        ->middleware('guest');
    Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])
        ->name('password.email')
        ->middleware('guest');

    // Reset password routes
    Route::get('reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])
        ->name('password.reset')
        ->middleware('guest');
    Route::post('forgot-password', [ForgotPasswordController::class, 'reset'])
        ->name('password.reset')
        ->middleware('guest');

    // Authenticated routes
    Route::group(['middleware'=> 'auth:admin'], function(){
        
        // Logout
        Route::post('logout', [LoginController::class, 'logout'])
        ->name('logout');
        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

        // Profile
        Route::get('profile', [ProfileController::class, 'index'])
        ->name('profile');
        Route::put('profile', [ProfileController::class, 'update'])
        ->name('profile.update');

        // Password
        Route::get('password', [PasswordController::class, 'index'])
        ->name('password');
        Route::put('password', [PasswordController::class, 'update'])
        ->name('password.update');

        // Users
        Route::put('users/{user}/restore', [UsersController::class, 'restore'])
            ->name('users.restore');
        Route::put('users/{user}/toggle-status', [UsersController::class, 'toggleStatus'])
            ->name('users.toggle.status');
        Route::resource('users', UsersController::class)
            ->except('show');

        // Enquries
        Route::put('enquiries/{enquiry}/restore', [EnquiryController::class, 'restore'])
            ->name('enquiries.restore');
        Route::resource('enquiries', EnquiryController::class)
            ->except(['create', 'store', 'edit', 'update']);

        // Faqs
        Route::put('faqs/{faq}/restore', [FaqController::class, 'restore'])
            ->name('faqs.restore');
        Route::put('faqs/{faq}/toggle-status', [FaqController::class, 'toggleStatus'])
            ->name('faqs.toggle.status');
        Route::resource('faqs', FaqController::class)
            ->except('show');

        // Pages
        Route::resource('pages', PageController::class)
            ->except(['create', 'store']);

        // Email Templates
        Route::resource('email-templates', EmailTemplateController::class)
            ->except(['create', 'store']);
        
        // Settings
        Route::get('settings', [SettingController::class, 'index'])
            ->name('settings');
        Route::put('settings', [SettingController::class, 'update'])
        ->name('settings.update');

        // Reports
        Route::get('reports', [ReportsController::class, 'index'])
            ->name('reports');
    });
    
});

// Images

Route::get('/images/{path}', [ImagesController::class, 'show'])->where('path', '.*');

// 500 error

Route::get('500', function () {
    // Force debug mode for this endpoint in the demo environment
    if (App::environment('demo')) {
        Config::set('app.debug', true);
    }

    echo $fail;
});
