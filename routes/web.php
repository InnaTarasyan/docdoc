<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\SpecialtyController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\LegalController;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Lightweight API for autocomplete
Route::get('/api/search/doctors', [DoctorController::class, 'search'])->name('api.search.doctors');

// Unified search
Route::get('/search', [SearchController::class, 'index'])->name('search.index');

Route::get('/doctors', [DoctorController::class, 'index'])->name('doctors.index');
Route::get('/doctors/{doctor}', [DoctorController::class, 'show'])->name('doctors.show');

Route::get('/organizations', [OrganizationController::class, 'index'])->name('organizations.index');
Route::get('/organizations/{organization}', [OrganizationController::class, 'show'])->name('organizations.show');

Route::get('/specialties', [SpecialtyController::class, 'index'])->name('specialties.index');

// Legal pages
Route::get('/privacy-policy', [LegalController::class, 'privacy'])->name('legal.privacy');
Route::get('/terms-of-use', [LegalController::class, 'terms'])->name('legal.terms');
