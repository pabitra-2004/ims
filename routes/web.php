<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::view('categories', 'categories.index')->name('categories.index');
    Route::view('products', 'products.index')->name('products.index');
    Route::view('inventory', 'inventory')->name('inventory');
    Route::livewire('states', 'pages::state-list')->name('states');
    Route::livewire('districts', 'pages::district-list')->name('districts');
});

require __DIR__ . '/settings.php';
