<script>
    let seconds = 60;
    const timer = document.getElementById('timer');
    
    // Check payment status every 3 seconds
    const checkPayment = setInterval(async () => {
        const res = await fetch('/payment-status/{{ $registration->id }}');
        const data = await res.json();
        if (data.paid) {
            clearInterval(checkPayment);
            clearInterval(countdown);
            window.location.href = '/success';
        }
    }, 3000);

    // Countdown timer
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