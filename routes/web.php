<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\TermsController;
use App\Http\Controllers\BookingController;

// Admin Controllers
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\CustomerController as AdminCustomerController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use Laravel\Socialite\Socialite;
use App\Http\Controllers\Auth\GoogleController;

require __DIR__ . '/auth.php';

// Google OAuth Routes
Route::get('auth/google', [GoogleController::class, 'redirectToGoogle']);
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::get('/faq', [FaqController::class, 'index'])->name('faq');
Route::get('/terms', [TermsController::class, 'index'])->name('terms');
Route::view('/cars', 'cars')->name('cars');
Route::view('/tours', 'tours')->name('tours');
Route::view('/membership', 'membership')->name('membership');

// Search Routes (Public)
Route::get('/search/cars', [HomeController::class, 'searchCars'])->name('search.cars');
Route::get('/search/tours', [HomeController::class, 'searchTours'])->name('search.tours');

// User Routes
Route::middleware('auth', 'role:user')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Booking Routes
    Route::get('/booking/book', [BookingController::class, 'create'])->name('booking.create');
    Route::post('/booking/store', [BookingController::class, 'store'])->name('booking.store');

    // Payment Flow
    Route::get('/booking/payment/{id}', [BookingController::class, 'payment'])->name('booking.payment');
    Route::post('/booking/process/{id}', [BookingController::class, 'processPayment'])->name('booking.process');
    Route::get('/booking/success/{id}', [BookingController::class, 'success'])->name('booking.success');
});

// Admin Routes
Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Booking Routes
    Route::get('/bookings', [AdminBookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/{id}', [AdminBookingController::class, 'show'])->name('bookings.show');
    Route::put('/bookings/{id}', [AdminBookingController::class, 'update'])->name('bookings.update');

    // Products (Cars & Tours)
    Route::resource('products', AdminProductController::class);

    // Customers
    Route::resource('customers', AdminCustomerController::class)->parameters([
        'customers' => 'user'
    ]);
});
