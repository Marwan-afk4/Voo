<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Password Reset Code</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f7f7f7; padding: 30px;">

    <div style="max-width: 600px; margin: auto; background-color: white; padding: 40px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
        <h2 style="color: #333; text-align: center;">Forgot Your Password?</h2>

        <p style="font-size: 16px; color: #555;">
            Hi <strong>{{ $name }}</strong>,
        </p>

        <p style="font-size: 16px; color: #555;">
            We received a request to reset your password. Use the verification code below to continue:
        </p>

        <div style="text-align: center; margin: 30px 0;">
            <div style="display: inline-block; padding: 15px 25px; font-size: 24px; background-color: #007bff; color: white; border-radius: 6px; letter-spacing: 4px;">
                {{ $code }}
            </div>
        </div>

        <p style="font-size: 14px; color: #777;">
            This code will expire shortly. If you didn’t request a password reset, please ignore this email.
        </p>

        <p style="font-size: 14px; color: #777;">
            Regards,<br>
            The {{ config('app.name') }} Team
        </p>
    </div>
</body>
</html>
