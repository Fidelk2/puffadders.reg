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

Route::get('/test-network', function () {
    try {
        $response = \Illuminate\Support\Facades\Http::get('https://httpbin.org/get');
        return response()->json(['status' => $response->status(), 'ok' => $response->ok()]);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()]);
    }
});

Route::get('/test-stk', function () {
    $consumerKey    = env('MPESA_CONSUMER_KEY');
    $consumerSecret = env('MPESA_CONSUMER_SECRET');
    $shortcode      = env('MPESA_SHORTCODE');
    $passkey        = env('MPESA_PASSKEY');
    $appUrl         = env('APP_URL');

    $tokenResponse = \Illuminate\Support\Facades\Http::withBasicAuth($consumerKey, $consumerSecret)
        ->get('https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials');

    $token     = $tokenResponse->json()['access_token'];
    $timestamp = now()->format('YmdHis');
    $password  = base64_encode($shortcode . $passkey . $timestamp);

    $response = \Illuminate\Support\Facades\Http::withToken($token)
        ->post('https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest', [
            'BusinessShortCode' => $shortcode,
            'Password'          => $password,
            'Timestamp'         => $timestamp,
            'TransactionType'   => 'CustomerPayBillOnline',
            'Amount'            => 100,
            'PartyA'            => '254708374149',
            'PartyB'            => $shortcode,
            'PhoneNumber'       => '254708374149',
            'CallBackURL'       => $appUrl . '/mpesa/callback',
            'AccountReference'  => 'REG-TEST',
            'TransactionDesc'   => 'Event Registration',
        ]);

    return response()->json($response->json());
});