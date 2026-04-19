<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ContactController;

Route::get('/', [HomeController::class, 'index']);
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Route sementara untuk migrasi di Vercel
Route::get('/migrate-database', function () {
    try {
        \Illuminate\Support\Facades\Artisan::call('migrate:force');
        return "Migration success: " . \Illuminate\Support\Facades\Artisan::output();
    } catch (\Exception $e) {
        return "Migration failed: " . $e->getMessage();
    }
});