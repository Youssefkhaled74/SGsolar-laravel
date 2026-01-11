<?php

use Illuminate\Support\Facades\Route;

Route::prefix('lead')->group(function () {
    Route::post('/contact', function () {
        return response()->json(['status' => 'ok', 'message' => 'contact received']);
    })->name('lead.contact');

    Route::post('/product-inquiry', function () {
        return response()->json(['status' => 'ok', 'message' => 'product inquiry received']);
    })->name('lead.product_inquiry');
});
