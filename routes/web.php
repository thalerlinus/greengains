<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Legal Pages (Static Inertia Views)
Route::get('/impressum', function () { return Inertia::render('Legal/Impressum'); })->name('legal.impressum');
Route::get('/datenschutz', function () { return Inertia::render('Legal/Datenschutz'); })->name('legal.datenschutz');
Route::get('/agb', function () { return Inertia::render('Legal/AGB'); })->name('legal.agb');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
