<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('categories', function () {
    return view('categories.index');
})
    ->middleware(['auth', 'verified'])
    ->name('categories.index');



Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('products', 'products.index')->middleware(['auth', 'verified'])->name('products.index');

require __DIR__ . '/settings.php';
