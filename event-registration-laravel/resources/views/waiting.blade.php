<script>
    let seconds = 120;
    const timer = document.getElementById('timer');

    const checkPayment = setInterval(async () => {
        try {
            const res = await fetch('/payment-status/{{ $registration->id }}');
            const data = await res.json();
            console.log('Payment status:', data);
            if (data.paid == 1 || data.paid === true) {
                clearInterval(checkPayment);
                clearInterval(countdown);
                window.location.href = '/success';
            }
        } catch(e) {
            console.log('Error checking payment:', e);
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