<?php

use App\Http\Controllers\IngressoController;
use Illuminate\Support\Facades\Route;

Route::get('/', [IngressoController::class, 'index']);