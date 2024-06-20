<?php

use App\Http\Controllers\PfpController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UploadController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::post('/upload', [UploadController::class, 'storePfp'])->name('storePfp');

Route::get('/pfp/{id}', [PfpController::class, 'show'])->name('pfpShow');


