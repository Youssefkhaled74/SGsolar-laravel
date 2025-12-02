<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\ContactController;

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

// Contact Page
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
