<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;

Route::get('/', [EventController::class, 'index']);
Route::get('/search', [EventController::class, 'search']);
Route::get('/filter', [EventController::class, 'filter']);

// Events
Route::get('/events/create', [EventController::class, 'create'])->name('events.create')->middleware('seller');
Route::get('/events/{id}', [EventController::class, 'show'])->name('events.show');
Route::get('/events/{id}/edit', [EventController::class, 'edit'])->name('events.edit')->middleware('seller');
Route::put('/events/{id}', [EventController::class, 'update'])->name('events.update')->middleware('seller');
Route::delete('/events/{id}', [EventController::class, 'destroy'])->name('events.destroy')->middleware('seller');
Route::post('/events', [EventController::class, 'store']);

// Tickets
Route::get('/tickets/create', [TicketController::class, 'create'])->name('tickets.create')->middleware('seller');
Route::get('/tickets/{id}/edit', [TicketController::class, 'edit'])->name('tickets.edit')->middleware('seller');
Route::put('/tickets/{id}', [TicketController::class, 'update'])->name('tickets.update')->middleware('seller');
Route::delete('/tickets/{id}', [TicketController::class, 'destroy'])->name('tickets.destroy')->middleware('seller');
Route::post('/tickets', [TicketController::class, 'store']);

Route::get('/my-tickets', function () {
    return view('my-tickets');
});


// Seller
Route::get('/seller/create', [SellerController::class, 'create'])->name('seller.create')->middleware('auth');
Route::post('/seller', [SellerController::class, 'store'])->middleware('auth');
Route::get('/seller/index', [SellerController::class, 'index'])->name('seller.index')->middleware('auth');

// Cart
Route::get('/carrinho', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::delete('/cart/{id}', [CartController::class, 'destroy'])->name('cart.destroy');

// Checkout
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');



Route::get('/pagamento', function () {
    return view('pagamento');
});

// Jetsream
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
