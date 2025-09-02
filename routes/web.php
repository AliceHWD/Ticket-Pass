<?php

use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;

Route::get('/', [TicketController::class, 'index']);
Route::get('/search', [TicketController::class, 'search']);
Route::get('/filter', [TicketController::class, 'filter']);

Route::get('/vendas', function () {
    return view('vendas');
});

Route::get('/carrinho', function () {
    return view('carrinho');
});

Route::get('/pagamento', function () {
    return view('pagamento');
});

Route::get('/tickets/{id}', [TicketController::class, 'show']);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
