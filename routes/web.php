<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\AdminController;

// Language Switcher
Route::get('/locale/{locale}', [LocaleController::class, 'switch'])->name('locale.switch');

// Home Page
Route::get('/', [HomeController::class, 'index'])->name('home');

// About Page
Route::get('/about', [AboutController::class, 'index'])->name('about');

// Products Page
Route::get('/products', [ProductsController::class, 'index'])->name('products');

// Services Page
Route::get('/services', [ServicesController::class, 'index'])->name('services');

// Gallery Page
Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery');

// Solutions Page
Route::view('/solutions', 'pages.solutions')->name('solutions');

// Projects Page
Route::view('/projects', 'pages.projects')->name('projects');

// News/Blog Pages
Route::view('/news', 'pages.news')->name('news');
Route::view('/news/{slug}', 'pages.news-single')->name('news.single');

// Contact Page
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');

// Admin Routes
Route::prefix('dashboard_admin')->group(function () {
    Route::get('/login', [AdminController::class, 'showLogin'])->name('admin.login');
    Route::post('/login', [AdminController::class, 'login'])->name('admin.login.submit');
    Route::get('/logout', [AdminController::class, 'logout'])->name('admin.logout');
    Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::post('/contact/{id}/status', [AdminController::class, 'updateStatus'])->name('admin.contact.status');
    Route::delete('/contact/{id}', [AdminController::class, 'deleteContact'])->name('admin.contact.delete');
});
