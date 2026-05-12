<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 30px auto; background: #fff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        .header { background: #2563eb; color: #fff; padding: 24px 32px; }
        .header h2 { margin: 0; font-size: 20px; }
        .body { padding: 28px 32px; color: #333; line-height: 1.7; font-size: 15px; }
        .footer { background: #f0f0f0; text-align: center; padding: 14px; font-size: 12px; color: #888; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>{{ $emailSubject }}</h2>
        </div>
        <div class="body">
            <p>Dear Member,</p>
            {!! nl2br(e($emailBody)) !!}
            <br>
            <p>Regards,<br><strong>{{ $senderName }}</strong></p>
        </div>
        <div class="footer">
            This email was sent via the NextCome Family Tree platform.
        </div>
    </div>
</body>
</html>
