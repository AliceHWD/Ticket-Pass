<?php

use App\Http\Controllers\SellerController;
use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;

// Tickets
Route::get('/', [TicketController::class, 'index']);
Route::get('/search', [TicketController::class, 'search']);
Route::get('/filter', [TicketController::class, 'filter']);
Route::get('/tickets/create', [TicketController::class, 'create'])->name('tickets.create')->middleware('seller');
Route::get('/tickets/{id}', [TicketController::class, 'show']);
Route::post('/tickets', [TicketController::class, 'store']);

// Seller
Route::get('/seller/create', [SellerController::class, 'create'])->name('seller.create')->middleware('auth');
Route::post('/seller', [SellerController::class, 'store']);

Route::get('/carrinho', function () {
    return view('carrinho');
});

Route::get('/pagamento', function () {
    return view('pagamento');
});


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
