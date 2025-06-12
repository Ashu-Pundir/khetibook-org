<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>KhetiBook OTP Verification</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    @media only screen and (max-width: 620px) {
      .container {
        width: 100% !important;
        padding: 0 20px !important;
      }
      .otp-box {
        font-size: 22px !important;
        padding: 12px 18px !important;
      }
      h2 {
        font-size: 20px !important;
      }
      p {
        font-size: 14px !important;
      }
    }
  </style>
</head>
<body style="margin:0;padding:0;background-color:#f4f4f9;font-family:'Segoe UI',sans-serif;">

  <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f4f9;">
    <tr>
      <td align="center">
        <table class="container" width="600" cellpadding="0" cellspacing="0" style="background-color:#ffffff;border-radius:16px;box-shadow:0 10px 30px rgba(0,0,0,0.1);overflow:hidden;width:600px;max-width:100%;">

          <!-- Logo -->
          <tr>
            <td style="padding:40px 0;" align="center">
              <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/1/1e/Eo_circle_light-green_letter-k.svg/768px-Eo_circle_light-green_letter-k.svg.png?20200417151822" alt="KhetiBook Logo" width="48" height="48" style="display:block;">
            </td>
          </tr>

          <!-- Title -->
          <tr>
            <td style="padding:0 40px;text-align:center;">
              <h2 style="margin:0;color:#333;font-size:24px;font-weight:600;">
                Verify your KHETIBOOK Sign-up
              </h2>
              <p style="margin:12px 0 0;color:#555;font-size:15px;line-height:1.5;">
                We received a sign-up attempt. Enter this code where you initiated sign-up:
              </p>
            </td>
          </tr>

          <!-- OTP Box -->
          <tr>
            <td style="padding:20px 40px 0;text-align:center;">
              <div class="otp-box" style="display:inline-block;background:#f1f2f4;border-radius:8px;padding:15px 25px;font-size:28px;font-weight:600;letter-spacing:4px;color:#333;">
                {{ $otp }}
              </div>
            </td>
          </tr>

          <!-- OR Text -->
          <tr>
            <td style="padding:10px 40px 0;text-align:center;">
              <p style="margin:0;color:#666;font-size:14px;font-weight:500;">OR</p>
            </td>
          </tr>

          <!-- Verify Button -->
          <tr>
            <td style="padding:10px 40px 20px;text-align:center;">
              <a href="{{ $verifyUrl }}" style="display:inline-block;padding:10px 20px;background-color:#28a745;color:#fff;text-decoration:none;border-radius:6px;font-weight:600;font-size:15px;">
                CLICK HERE TO VERIFY
              </a>
            </td>
          </tr>


          <!-- Info Text -->
          <tr>
            <td style="padding:0 40px 20px;text-align:center;">
              <p style="margin:0;color:#777;font-size:13px;line-height:1.5;">
                If you did not attempt to sign-up, please ignore this email. This code is valid for 10 minutes.
              </p>
            </td>
          </tr>

          <!-- Footer -->
          <tr>
            <td style="padding:20px 40px;text-align:center;border-top:1px solid #eee;">
              <p style="margin:0;color:#888;font-size:12px;">
                KhetiBook, your smart farming assistant.
              </p>
              <p style="margin:0;color:#aaa;font-size:11px;">&copy; {{ date('Y') }} KhetiBook. All rights reserved.</p>
            </td>
          </tr>

        </table>
      </td>
    </tr>
  </table>

</body>
</html>
