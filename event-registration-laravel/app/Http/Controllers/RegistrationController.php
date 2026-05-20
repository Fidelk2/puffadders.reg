<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class RegistrationController extends Controller
{
    public function index()
    {
        return view('register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'   => 'required|string',
            'email'  => 'required|email',
            'phone'  => 'required|string',
            'course' => 'required|string',
        ]);

        try {
            $registration = Registration::create([
                'name'   => $request->name,
                'email'  => $request->email,
                'phone'  => $request->phone,
                'course' => $request->course,
                'paid'   => false,
            ]);

            $response = $this->stkPush($request->phone, $registration->id);

            if (isset($response['CheckoutRequestID'])) {
                $registration->update([
                    'checkout_request_id' => $response['CheckoutRequestID']
                ]);
            }

            return view('waiting', ['registration' => $registration]);

        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function callback(Request $request)
    {
        $body = $request->input('Body.stkCallback');

        if (!$body || $body['ResultCode'] !== 0) {
            return response()->json(['ResultCode' => 0]);
        }

        $checkoutRequestId = $body['CheckoutRequestID'];
        $registration = Registration::where('checkout_request_id', $checkoutRequestId)->first();

        if (!$registration) return response()->json(['ResultCode' => 0]);

        $registration->update(['paid' => true]);

        Mail::send('emails.confirmation', ['registration' => $registration], function ($mail) use ($registration) {
            $mail->to($registration->email)
                 ->subject('🎉 You are registered — ' . $registration->course);
        });

        return response()->json(['ResultCode' => 0]);
    }

    public function success()
    {
        return view('success');
    }

    private function stkPush($phone, $registrationId)
    {
        $consumerKey    = env('MPESA_CONSUMER_KEY');
        $consumerSecret = env('MPESA_CONSUMER_SECRET');
        $shortcode      = env('MPESA_SHORTCODE');
        $passkey        = env('MPESA_PASSKEY');
        $appUrl         = env('APP_URL');

        $tokenResponse = Http::withBasicAuth($consumerKey, $consumerSecret)
            ->get('https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials');

        if ($tokenResponse->failed()) {
            throw new \Exception('Failed to get M-Pesa token: ' . $tokenResponse->body());
        }

        $tokenData = $tokenResponse->json();

        if (!isset($tokenData['access_token'])) {
            throw new \Exception('No access token in response: ' . json_encode($tokenData));
        }

        $token     = $tokenData['access_token'];
        $timestamp = now()->format('YmdHis');
        $password  = base64_encode($shortcode . $passkey . $timestamp);
        $formatted = '254' . ltrim(preg_replace('/\s+/', '', $phone), '0');

        $response = Http::withToken($token)
            ->post('https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest', [
                'BusinessShortCode' => $shortcode,
                'Password'          => $password,
                'Timestamp'         => $timestamp,
                'TransactionType'   => 'CustomerPayBillOnline',
                'Amount'            => 100,
                'PartyA'            => $formatted,
                'PartyB'            => $shortcode,
                'PhoneNumber'       => $formatted,
                'CallBackURL'       => $appUrl . '/mpesa/callback',
                'AccountReference'  => 'REG-' . $registrationId,
                'TransactionDesc'   => 'Event Registration',
            ]);

        return $response->json();
    }
}