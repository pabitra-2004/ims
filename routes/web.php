<?php

use App\Livewire\Orders\CreateOrder;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

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
    Route::view('customers', 'customers.index')->name('customers.index');
    Route::view('orders', 'orders.index')->name('orders.index');
    Route::livewire('create-orders', 'orders.create-order')->name('orders.create-order');
});

require __DIR__ . '/settings.php';
