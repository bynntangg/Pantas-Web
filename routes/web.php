<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Redirect root ke index.html
Route::get('/', function () {
    return redirect('/index.html');
});

// Atau langsung tampilkan file HTML tanpa redirect
Route::get('/', function () {
    return response()->file(public_path('index.html'));
});

// Route lain tetap berjalan
Route::get('/login', function () {
    return redirect('/index.html#login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
