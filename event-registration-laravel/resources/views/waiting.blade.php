@extends('layouts.app')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 text-center">

    <div class="w-16 h-16 bg-yellow-50 rounded-full flex items-center justify-center mx-auto mb-4">
        <span class="text-3xl">📱</span>
    </div>

    <h2 class="text-lg font-semibold text-gray-800 mb-2">Check your phone</h2>
    <p class="text-sm text-gray-500 mb-1">An M-Pesa prompt has been sent to</p>
    <p class="font-semibold text-gray-800 mb-1">{{ $registration->phone }}</p>
    <p class="text-sm text-gray-400 mb-6">Enter your M-Pesa PIN to pay <span class="text-green-700 font-semibold">Ksh 1</span></p>

    <div class="bg-green-800 text-white rounded-xl p-4 text-left mb-6">
        <p class="font-semibold text-sm mb-1">M-PESA</p>
        <p class="text-xs opacity-80">Pay Ksh 1.00 to MASTERCLASS EVENTS for account REG-{{ $registration->id }}? Enter PIN to confirm.</p>
    </div>

    <div id="countdown" class="text-sm text-gray-400 mb-4">
        Waiting for payment... <span id="timer" class="font-semibold text-gray-700">60</span>s
    </div>

    <a href="/" class="text-sm text-green-600 hover:underline">← Go back and try again</a>
</div>

<script>
    let seconds = 60;
    const timer = document.getElementById('timer');

    const checkPayment = setInterval(async () => {
        const res = await fetch('/payment-status/{{ $registration->id }}');
        const data = await res.json();
        if (data.paid == 1 || data.paid === true) {
            clearInterval(checkPayment);
            clearInterval(countdown);
            window.location.href = '/success';
        }
    }, 3000);

    const countdown = setInterval(() => {
        seconds--;
        timer.textContent = seconds;
        if (seconds <= 0) {
            clearInterval(countdown);
            clearInterval(checkPayment);
            document.getElementById('countdown').innerHTML = '<span class="text-red-500">Prompt expired. <a href="/" class="underline">Try again</a></span>';
        }
    }, 1000);
</script>
@endsection