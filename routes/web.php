<?php

use App\Http\Controllers\Customer\Auth\LoginController;
use App\Http\Controllers\Customer\DashboardController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', [LandingController::class, 'index'])->name('landing');

// Public Auth Routes
Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

// Customer Auth Routes
Route::prefix('customer')->name('customer.')->group(function () {
    // Login routes redirect to public login
    Route::get('/login', function () {
        if (Auth::check() && Auth::user()->role === 'CUSTOMER') {
            return redirect()->route('customer.dashboard');
        }
        return redirect()->route('login');
    })->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    // Protected routes
    Route::middleware('auth')->group(function () {
        Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Packages
        Route::get('/packages', [\App\Http\Controllers\Customer\PackageController::class, 'index'])->name('packages.index');
        Route::get('/packages/{package}', [\App\Http\Controllers\Customer\PackageController::class, 'show'])->name('packages.show');

        // Orders
        Route::post('/packages/{package}/order', [\App\Http\Controllers\Customer\OrderController::class, 'store'])->name('orders.store');
        Route::get('/orders/{order}', [\App\Http\Controllers\Customer\OrderController::class, 'show'])->name('orders.show');

        // Questions
        Route::get('/questions', [\App\Http\Controllers\Customer\QuestionController::class, 'index'])->name('questions.index');
        Route::get('/questions/create', [\App\Http\Controllers\Customer\QuestionController::class, 'create'])->name('questions.create');
        Route::post('/questions', [\App\Http\Controllers\Customer\QuestionController::class, 'store'])->name('questions.store');
        Route::get('/questions/{question}', [\App\Http\Controllers\Customer\QuestionController::class, 'show'])->name('questions.show');
        Route::post('/questions/{question}/messages', [\App\Http\Controllers\Customer\QuestionController::class, 'storeMessage'])->name('questions.messages.store');
        Route::post('/questions/messages/{message}/rate', [\App\Http\Controllers\Customer\QuestionController::class, 'rateMessage'])->name('questions.messages.rate');
        Route::post('/questions/{question}/rate-lawyer', [\App\Http\Controllers\Customer\QuestionController::class, 'rateLawyer'])->name('questions.rate-lawyer');
        Route::post('/questions/{question}/close', [\App\Http\Controllers\Customer\QuestionController::class, 'closeQuestion'])->name('questions.close');

        // FAQs
        Route::get('/faqs', [\App\Http\Controllers\Customer\FaqController::class, 'index'])->name('faqs.index');

        // Videos
        Route::get('/videos', [\App\Http\Controllers\Customer\VideoController::class, 'index'])->name('videos.index');
        Route::get('/videos/{video}', [\App\Http\Controllers\Customer\VideoController::class, 'show'])->name('videos.show');
    });
});
