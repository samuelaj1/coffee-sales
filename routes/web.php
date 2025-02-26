<?php

use App\Http\Controllers\SalesController;
use Illuminate\Support\Facades\Route;


Route::get('/', [SalesController::class, 'index'])->name('sales');

