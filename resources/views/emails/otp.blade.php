<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>OTP Verification</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f4f4f7; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;">
        <tr>
            <td align="center" style="padding: 40px 0;">
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05); border: 1px solid #e1e6eb;">
                    <!-- Header -->
                    <tr>
                        <td align="center" style="background-color: #e60000; padding: 30px 20px;">
                            <h1 style="margin: 0; color: #ffffff; font-size: 24px; font-weight: 800; text-transform: uppercase; letter-spacing: 1px;">UNITED SENIORS VELLANAD</h1>
                        </td>
                    </tr>
                    
                    <!-- Content -->
                    <tr>
                        <td style="padding: 40px 30px; color: #333333; font-size: 16px; line-height: 1.6;">
                            <p style="margin-top: 0;">Hello,</p>
                            <p>You have requested a secure OTP to log in or verify your account. Please use the verification code below to complete the process:</p>
                            
                            <!-- OTP Box -->
                            <div align="center" style="margin: 30px 0;">
                                <table border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td align="center" style="background-color: #f7f9fa; border: 2px dashed #e60000; border-radius: 12px; padding: 15px 40px;">
                                            <span style="font-size: 36px; font-weight: 800; letter-spacing: 6px; color: #e60000; font-family: Courier, monospace;">{{ $otp }}</span>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            
                            <p style="font-size: 14px; color: #666666; margin-bottom: 0;">Note: This OTP code is valid for 10 minutes. Please do not share this code with anyone.</p>
                        </td>
                    </tr>
                    
                    <!-- Footer -->
                    <tr>
                        <td align="center" style="background-color: #fcfcfd; padding: 20px; font-size: 12px; color: #999999; border-top: 1px solid #eeeeee;">
                            <p style="margin: 0 0 5px 0;">&copy; {{ date('Y') }} United Seniors Vellanad. All rights reserved.</p>
                            <p style="margin: 0;">Vellanad, Trivandrum, Kerala</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
