<?php

use Illuminate\Support\Facades\Route;

Route::prefix('sales')->middleware(['auth', 'role:sales'])->group(function () {
    Route::get('/', function () {
        return view('sales.dashboard');
    })->name('sales.dashboard');

    Route::get('/leads', function () {
        return view('sales.leads.index');
    })->name('sales.leads.index');
});
