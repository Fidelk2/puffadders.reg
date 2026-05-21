@extends('layouts.app')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 text-center">
    <div class="w-16 h-16 bg-green-50 rounded-full flex items-center justify-center mx-auto mb-4">
        <span class="text-3xl">🎉</span>
    </div>
    <h2 class="text-lg font-semibold text-gray-800 mb-2">Payment Confirmed!</h2>
    <p class="text-sm text-gray-500 mb-6">Your registration is complete. Check your email for the event details.</p>
    <div class="bg-gray-50 rounded-lg p-4 text-left">
        <p class="text-sm font-medium text-gray-700 mb-2">What's next:</p>
        <ul class="text-sm text-gray-500 space-y-2">
            <li>✅ Check your email for the YouTube Live link</li>
            <li>✅ Save the passcode: <strong>LEARN2025</strong></li>
            <li>✅ Add the event to your calendar</li>
        </ul>
    </div>
    <a href="/" class="block mt-6 text-sm text-green-600 hover:underline">← Register another person</a>
</div>
@endsection