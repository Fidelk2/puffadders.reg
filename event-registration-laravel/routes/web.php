<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistrationController;

Route::get('/', [RegistrationController::class, 'index']);
Route::post('/register', [RegistrationController::class, 'store'])->name('register');
Route::post('/mpesa/callback', [RegistrationController::class, 'callback'])->name('mpesa.callback');
Route::get('/success', [RegistrationController::class, 'success'])->name('success');

Route::get('/test-mpesa', function () {
    $consumerKey    = env('MPESA_CONSUMER_KEY');
    $consumerSecret = env('MPESA_CONSUMER_SECRET');

    try {
        $tokenResponse = \Illuminate\Support\Facades\Http::withBasicAuth($consumerKey, $consumerSecret)
            ->get('https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials');

        return response()->json([
            'status' => $tokenResponse->status(),
            'body'   => $tokenResponse->json(),
        ]);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()]);
    }
});