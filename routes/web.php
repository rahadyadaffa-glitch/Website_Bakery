<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Customer\MenuController;
use App\Http\Controllers\Customer\CartController;
use App\Http\Controllers\Customer\OrderController;
use App\Http\Controllers\Customer\PaymentController;

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\MenuController as AdminMenuController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\TableController;

Route::get('/menu/{category?}', [MenuController::class, 'index'])->name('menu.index');
Route::get('/', function(\Illuminate\Http\Request $request) { 
    return redirect()->route('menu.index', $request->query()); 
});

Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
Route::patch('/cart', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

Route::get('/checkout', [OrderController::class, 'checkout'])->name('order.checkout');
Route::post('/order', [OrderController::class, 'store'])->name('order.store');
Route::get('/order/{order}/success', [OrderController::class, 'success'])->name('order.success');

Route::get('/order/{order}/payment', [PaymentController::class, 'show'])->name('payment.show');
Route::post('/order/{order}/payment/confirm', [PaymentController::class, 'confirm'])->name('payment.confirm');

Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ─── Dashboard & Orders (Shared Base) ──────────────────────
Route::middleware(['auth', 'waiter'])->prefix('waiter')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Pesanan (Hanya untuk Waiter)
    Route::middleware(\App\Http\Middleware\OnlyWaiterMiddleware::class)->group(function() {
        Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/history', [AdminOrderController::class, 'history'])->name('orders.history');
        Route::get('/orders/table/{tableNumber}', [AdminOrderController::class, 'showTable'])->name('orders.table');
        Route::patch('/orders/{order}/process', [AdminOrderController::class, 'process'])->name('orders.process');
        Route::patch('/orders/{order}/complete', [AdminOrderController::class, 'complete'])->name('orders.complete');
        
        // Fitur baru per-meja (Struk Siap Antar)
        Route::get('/orders/table/{tableNumber}/receipt', [AdminOrderController::class, 'printTableReceipt'])->name('orders.table.receipt');
        Route::patch('/orders/item/{item}/status', [AdminOrderController::class, 'updateItemStatus'])->name('orders.item.status');
        Route::patch('/orders/table/{tableNumber}/complete', [AdminOrderController::class, 'completeTable'])->name('orders.table.complete');

    });
});

// ─── Admin Only (Management) ──────────────────────
Route::middleware(['auth', 'admin'])->prefix('management')->name('admin.')->group(function () {
    // Menu & Kategori
    Route::resource('menus', AdminMenuController::class);
    Route::patch('menus/{menu}/toggle', [AdminMenuController::class, 'toggleAvailability'])->name('menus.toggle');
    Route::resource('categories', AdminCategoryController::class);

    // QR Meja (Hanya Admin)
    Route::get('tables', [TableController::class, 'index'])->name('tables.index');
    Route::get('tables/{table}/qr', [TableController::class, 'showQr'])->name('tables.show_qr');
    Route::post('tables/qr', [TableController::class, 'generateQr'])->name('tables.qr');
});

require __DIR__.'/auth.php';
