<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>You're Registered</title>
</head>
<body style="margin:0; padding:0; background-color:#f4f4f7; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Helvetica, Arial, sans-serif;">
  <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f4f7; padding:32px 16px;">
    <tr>
      <td align="center">
        <table role="presentation" width="100%" style="max-width:560px; background-color:#ffffff; border-radius:16px; overflow:hidden;">
          <tr>
            <td style="background-color:#8892E7; padding:28px 32px;">
              <span style="color:#ffffff; font-size:20px; font-weight:700;">High on Life, Not on Drugs</span><br>
              <span style="color:#e6e8fb; font-size:13px;">Awareness Walk</span>
            </td>
          </tr>
          <tr>
            <td style="padding:32px;">
              <h1 style="margin:0 0 16px; font-size:20px; color:#1a1a1a;">You're Registered!</h1>

              <p style="margin:0 0 16px; font-size:14px; line-height:1.6; color:#4a4a4a;">
                Hi {{ $registration->full_name }},
              </p>

              <p style="margin:0 0 16px; font-size:14px; line-height:1.6; color:#4a4a4a;">
                Thank you for registering for the <strong>High on Life, Not on Drugs Awareness Walk</strong>,
                hosted by DevEdge CBHA Foundation in collaboration with NDLEA.
              </p>

              <table role="presentation" width="100%" style="background-color:#f4f4f7; border-radius:12px; margin:20px 0;">
                <tr>
                  <td style="padding:16px 20px; font-size:14px; color:#4a4a4a;">
                    <strong style="color:#1a1a1a;">Reference Number:</strong> {{ $registration->reference_number }}<br>
                    <strong style="color:#1a1a1a;">Date:</strong> Saturday, 18th July 2026<br>
                    <strong style="color:#1a1a1a;">Time:</strong> 8:00 AM<br>
                    <strong style="color:#1a1a1a;">Start Point:</strong> Monoliza, R.B Dikko Road, Central Business District, Abuja<br>
                    <strong style="color:#1a1a1a;">Dress Code:</strong> Comfortable walking shoes / campaign T-shirt if provided
                  </td>
                </tr>
              </table>

              <p style="margin:0 0 24px; font-size:14px; line-height:1.6; color:#4a4a4a;">
                Your ticket is attached to this email as a PDF — please bring it (printed or on
                your phone) for check-in at the assembly point.
              </p>

              <p style="margin:0; font-size:14px; line-height:1.6; color:#4a4a4a;">
                Thanks,<br>
                DevEdge for Capacity Building and Health Advancement Foundation<br>
                in collaboration with the National Drug Law Enforcement Agency (NDLEA)
              </p>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</body>
</html>