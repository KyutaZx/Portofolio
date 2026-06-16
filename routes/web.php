<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ContactController;

Route::get('/', [HomeController::class, 'index']);

Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Proxy route for S3 images to bypass ISP blocks on r2.dev
Route::get('/image-proxy/{path}', function ($path) {
    if (!Storage::disk('s3')->exists($path)) {
        abort(404);
    }
    return Storage::disk('s3')->response($path);
})->where('path', '.*')->name('image.proxy');
