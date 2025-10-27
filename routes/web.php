<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;

Route::get('/', [EventController::class, 'index']);
Route::get('/search', [SearchController::class, 'index']);
Route::get('/filter', [SearchController::class, 'filter']);

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

// Seller Asaas Setup
Route::get('/seller/asaas-setup', [\App\Http\Controllers\SellerAsaasController::class, 'showSubAccountForm'])->name('seller.asaas.setup')->middleware('auth');
Route::post('/seller/asaas-subconta', [\App\Http\Controllers\SellerAsaasController::class, 'createSubAccount'])->name('seller.asaas.create')->middleware('auth');

// Cart
Route::get('/carrinho', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::delete('/cart/{id}', [CartController::class, 'destroy'])->name('cart.destroy');

// Checkout
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');

// Payment
Route::get('/payment/{orderId}', [\App\Http\Controllers\PaymentController::class, 'show'])->name('payment.show');
Route::post('/payment/{orderId}/process', [\App\Http\Controllers\PaymentController::class, 'process'])->name('payment.process');
Route::post('/webhook/asaas', [\App\Http\Controllers\PaymentController::class, 'webhook'])->name('webhook.asaas');

// Histórico de Pagamentos
Route::get('/perfil/historico-pagamento', [\App\Http\Controllers\HistoricoPagamentoController::class, 'index'])->name('historico.pagamento')->middleware('auth');

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
