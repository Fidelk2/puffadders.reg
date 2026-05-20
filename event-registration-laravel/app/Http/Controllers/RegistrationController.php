private function stkPush($phone, $registrationId)
{
    $consumerKey    = env('MPESA_CONSUMER_KEY');
    $consumerSecret = env('MPESA_CONSUMER_SECRET');
    $shortcode      = env('MPESA_SHORTCODE');
    $passkey        = env('MPESA_PASSKEY');
    $appUrl         = env('APP_URL');

    // Get token
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