<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style>
  body { font-family: DejaVu Sans, sans-serif; margin: 0; padding: 0; color: #1a1a1a; }
  .header { background-color: #8892E7; padding: 24px; color: #ffffff; }
  .header .event { font-size: 18px; font-weight: bold; }
  .header .sub { font-size: 12px; color: #e6e8fb; margin-top: 4px; }
  .body { padding: 24px; }
  .ref { font-size: 13px; color: #6b6b6b; margin-bottom: 4px; }
  .ref strong { color: #1a1a1a; font-size: 16px; letter-spacing: 1px; }
  .name { font-size: 20px; font-weight: bold; margin: 12px 0 20px; }
  table.details { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
  table.details td { padding: 6px 0; font-size: 12px; vertical-align: top; }
  table.details td.label { color: #6b6b6b; width: 90px; }
  table.details td.value { color: #1a1a1a; font-weight: bold; }
  .qr { text-align: center; padding: 12px 0 4px; }
  .qr img { width: 160px; height: 160px; }
  .footer { text-align: center; font-size: 10px; color: #9a9a9a; padding: 12px 24px 24px; }
</style>
</head>
<body>
  <div class="header">
    <div class="event">High on Life, Not on Drugs</div>
    <div class="sub">Awareness Walk</div>
  </div>

  <div class="body">
    <div class="ref">Reference Number<br><strong>{{ $registration->reference_number }}</strong></div>
    <div class="name">{{ $registration->full_name }}</div>

    <table class="details">
      <tr>
        <td class="label">Date</td>
        <td class="value">Saturday, 18th July 2026</td>
      </tr>
      <tr>
        <td class="label">Time</td>
        <td class="value">9:00 AM</td>
      </tr>
      <tr>
        <td class="label">Venue</td>
        <td class="value">NDLEA Head Office, Abuja</td>
      </tr>
      <tr>
        <td class="label">Dress Code</td>
        <td class="value">Comfortable walking shoes / campaign T-shirt if provided</td>
      </tr>
    </table>

    <div class="qr">
      <img src="{{ $qrDataUri }}" alt="QR Code">
    </div>
  </div>

  <div class="footer">
    Present this ticket (printed or on your phone) at the walk assembly point for check-in.<br>
    DevEdge for Capacity Building and Health Advancement Foundation, in collaboration with NDLEA.
  </div>
</body>
</html>