<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $stats = [
        'total_sales' => \App\Models\Sale::sum('grand_total'),
        'sales_count' => \App\Models\Sale::count(),
        'products_count' => \App\Models\Product::count(),
        'customers_count' => \App\Models\Customer::count(),
        'low_stock' => \App\Models\Product::where('stock_quantity', '<', 10)->get(),
        'recent_sales' => \App\Models\Sale::latest()->take(5)->get(),
    ];
    return view('dashboard', compact('stats'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::middleware('admin')->group(function () {
        Route::resource('users', UserController::class);
        Route::resource('roles', RoleController::class);
        Route::resource('sales', SaleController::class);
        Route::get('sales/{sale}/invoice', [SaleController::class, 'invoice'])->name('sales.invoice');
        Route::resource('products', ProductController::class);
        Route::resource('customers', CustomerController::class);
    });

    Route::get('lang/{locale}', function ($locale) {
        if (in_array($locale, ['en', 'ta', 'si'])) {
            session(['locale' => $locale]);
        }
        return redirect()->back();
    })->name('lang.switch');
});

require __DIR__.'/auth.php';
