<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistrationController;

Route::get('/', [RegistrationController::class, 'index']);
Route::post('/register', [RegistrationController::class, 'store'])->name('register');
Route::post('/mpesa/callback', [RegistrationController::class, 'callback'])->name('mpesa.callback');
Route::get('/success', [RegistrationController::class, 'success'])->name('success');