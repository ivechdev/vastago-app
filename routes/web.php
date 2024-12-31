<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\Admin\PanelAdminController;
use Illuminate\Support\Facades\Route;

// Ruta principal redirige al dashboard
Route::redirect('/', '/dashboard');

// Rutas protegidas por autenticación y verificación
Route::middleware(['auth', 'verified', 'admin'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Panel Admin
    Route::get('/admin', [PanelAdminController::class, 'index'])->name('admin.panel');
});

// Rutas protegidas por autenticación
Route::middleware(['auth'])->group(function () {
    // Productos
    Route::resource('products', ProductController::class);

    // Mesas
    Route::resource('tables', TableController::class);
    Route::post('/tables/{table}/occupy', [TableController::class, 'occupy'])->name('tables.occupy');
    Route::post('/tables/{table}/release', [TableController::class, 'release'])->name('tables.release');
    Route::delete('/tables/{table}', [TableController::class, 'destroy'])->name('tables.destroy');

    // Órdenes
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/create/{table_id}', [OrderController::class, 'create'])->name('orders.create');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('/orders/{order}/print', [OrderController::class, 'print'])->name('orders.print');
    Route::patch('/orders/{order}/complete', [OrderController::class, 'complete'])->name('orders.complete');
    Route::patch('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');

    // Inventario
    Route::resource('inventory', InventoryController::class);
    Route::post('/inventory/{inventory}/adjust', [InventoryController::class, 'adjustStock'])
        ->name('inventory.adjust');

    // Compras
    Route::resource('purchases', PurchaseController::class);
    Route::patch('/purchases/{purchase}/complete', [PurchaseController::class, 'complete'])->name('purchases.complete');
    Route::patch('/purchases/{purchase}/cancel', [PurchaseController::class, 'cancel'])->name('purchases.cancel');
});

// Rutas de perfil
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rutas de autenticación
require __DIR__.'/auth.php';
