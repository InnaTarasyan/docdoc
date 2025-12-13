<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\SpecialtyController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\LegalController;
use App\Http\Controllers\BlogController;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Lightweight API for autocomplete
Route::get('/api/search/doctors', [DoctorController::class, 'search'])->name('api.search.doctors');
Route::get('/api/search/autocomplete', [SearchController::class, 'autocomplete'])->name('api.search.autocomplete');

// Unified search
Route::get('/search', [SearchController::class, 'index'])->name('search.index');

Route::get('/doctors', [DoctorController::class, 'index'])->name('doctors.index');
Route::get('/doctors/{doctor}', [DoctorController::class, 'show'])->name('doctors.show');
Route::post('/doctors/{doctor}/reviews', [DoctorController::class, 'storeReview'])->name('doctors.reviews.store');

Route::get('/organizations', [OrganizationController::class, 'index'])->name('organizations.index');
Route::get('/organizations/{organization}', [OrganizationController::class, 'show'])->name('organizations.show');
Route::post('/organizations/{organization}/reviews', [OrganizationController::class, 'storeReview'])->name('organizations.reviews.store');

Route::get('/specialties', [SpecialtyController::class, 'index'])->name('specialties.index');

// Blog
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{post:slug}', [BlogController::class, 'show'])->name('blog.show');

// Legal pages
Route::get('/privacy-policy', [LegalController::class, 'privacy'])->name('legal.privacy');
Route::get('/terms-of-use', [LegalController::class, 'terms'])->name('legal.terms');

// About page
Route::get('/about', [LegalController::class, 'about'])->name('about');
