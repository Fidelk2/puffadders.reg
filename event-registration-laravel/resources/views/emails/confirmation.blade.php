<!DOCTYPE html>
<html>
<body style="font-family:sans-serif;max-width:520px;margin:auto;padding:20px">
    <div style="background:#0F6E56;padding:24px;border-radius:8px 8px 0 0">
        <p style="color:#9FE1CB;margin:0 0 4px;font-size:12px;text-transform:uppercase">Masterclass Events</p>
        <h1 style="color:#fff;margin:0;font-size:22px">You're in! 🎓</h1>
    </div>
    <div style="border:1px solid #eee;border-top:none;padding:24px;border-radius:0 0 8px 8px">
        <p>Hi <strong>{{ explode(' ', $registration->name)[0] }}</strong>,</p>
        <p>Your payment of <strong>Ksh 100</strong> was received. Here's everything you need:</p>

        <table style="width:100%;border-collapse:collapse;margin:16px 0">
            <tr>
                <td style="padding:8px 0;color:#666;font-size:14px">📅 Date</td>
                <td style="font-weight:500">Saturday, 7 June 2025</td>
            </tr>
            <tr>
                <td style="padding:8px 0;color:#666;font-size:14px">⏰ Time</td>
                <td style="font-weight:500">10:00 AM – 1:00 PM EAT</td>
            </tr>
            <tr>
                <td style="padding:8px 0;color:#666;font-size:14px">🔑 Passcode</td>
                <td style="font-weight:500">LEARN2025</td>
            </tr>
        </table>

        <p style="font-size:14px">▶️ <strong>YouTube Live:</strong><br>
            <a href="https://youtube.com/live/abc123xyz" style="color:#0F6E56">
                https://youtube.com/live/abc123xyz
            </a>
        </p>

        <a href="https://calendar.google.com/calendar/render?action=TEMPLATE&text=Web+Development+Masterclass&dates=20250607T070000Z/20250607T100000Z"
            style="display:block;background:#1D9E75;color:#fff;text-align:center;padding:12px;border-radius:6px;text-decoration:none;margin-top:20px;font-size:14px">
            + Add to Google Calendar
        </a>

        <p style="font-size:12px;color:#999;margin-top:24px;border-top:1px solid #eee;padding-top:16px">
            Questions? Reply to this email or WhatsApp us at +254 700 123 456.<br>
            This link and passcode are personal — please don't share them.
        </p>
    </div>
</body>
</html>