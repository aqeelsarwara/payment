<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return view('payment');
});

Route::post('/payment', [PaymentController::class, 'createPayment']);