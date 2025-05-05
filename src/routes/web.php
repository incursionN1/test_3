<?php

use App\Http\Controllers\orders\OrderCancelController;
use App\Http\Controllers\orders\OrderCompleteController;
use App\Http\Controllers\orders\OrderGetController;
use App\Http\Controllers\orders\OrderPatchController;
use App\Http\Controllers\orders\OrderPostController;
use App\Http\Controllers\orders\OrderResumeController;
use App\Http\Controllers\stock_history\StockHistoryGetController;
use App\Http\Controllers\stocks\StocksGetController;
use App\Http\Controllers\warehouses\WarehousesGetController;
use App\Models\warehouses;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::group(['namespace' => 'warehouses'], function () {
    Route::get('/api/warehouses',  [WarehousesGetController::class, '__invoke'])->name('warehouses.get');
});

Route::group(['namespace' => 'stocks'], function () {
    Route::get('/api/stocks',  [StocksGetController::class, '__invoke'])->name('stocks.get');
});

Route::group(['namespace' => 'stock_history'], function () {
    Route::get('/api/stock_history',  [StockHistoryGetController::class, '__invoke'])->name('stock_history.get');
});

Route::group(['namespace' => 'orders'], function () {
    Route::get('/api/orders',  [OrderGetController::class, '__invoke'])->name('orders.get');
    Route::post('/api/orders',  [OrderPostController::class, '__invoke'])->name('orders.post');
    Route::patch('/api/orders/{order}',  [OrderPatchController::class, '__invoke'])->name('orders.patch');
    Route::patch('/api/{order}/complete',  [OrderCompleteController::class, '__invoke'])->name('orders.complete');
    Route::patch('/api/{order}/cancel',  [OrderCancelController::class, '__invoke'])->name('orders.cancel');
    Route::patch('/api/{order}/resume',  [OrderResumeController::class, '__invoke'])->name('orders.resume');
});
