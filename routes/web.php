<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ProjectController;
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
Route::get('/products/swh', [ProductsController::class, 'swh'])->name('products.swh');
Route::get('/products/lights', [ProductsController::class, 'lights'])->name('products.lights');
Route::get('/products/panels', [ProductsController::class, 'panels'])->name('products.panels');

// Solutions Pages
Route::view('/solutions/on-grid', 'pages.solutions.on-grid')->name('solutions.on-grid');
Route::view('/solutions/off-grid', 'pages.solutions.off-grid')->name('solutions.off-grid');
Route::view('/solutions/hybrid', 'pages.solutions.hybrid')->name('solutions.hybrid');
Route::view('/solutions/pumping', 'pages.solutions.pumping')->name('solutions.pumping');
Route::view('/solutions/swh', 'pages.solutions.swh')->name('solutions.swh');
Route::view('/solutions/lighting', 'pages.solutions.lighting')->name('solutions.lighting');

// Projects Page
Route::get('/projects', [ProjectController::class, 'index'])->name('projects');

// News/Blog Pages
Route::view('/news', 'pages.news')->name('news');
Route::view('/news/{slug}', 'pages.news-single')->name('news.single');

// Feedback Section
Route::view('/feedback', 'pages.feedback')->name('feedback');

// Contact Page
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');

// Download Request
Route::post('/download-request', [AdminController::class, 'saveDownloadRequest'])->name('download.request');

// Admin Routes
Route::prefix('dashboard_admin')->group(function () {
    Route::get('/login', [AdminController::class, 'showLogin'])->name('admin.login');
    Route::post('/login', [AdminController::class, 'login'])->name('admin.login.submit');
    Route::get('/logout', [AdminController::class, 'logout'])->name('admin.logout');
    Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::post('/contact/{id}/status', [AdminController::class, 'updateStatus'])->name('admin.contact.status');
    Route::delete('/contact/{id}', [AdminController::class, 'deleteContact'])->name('admin.contact.delete');
});
