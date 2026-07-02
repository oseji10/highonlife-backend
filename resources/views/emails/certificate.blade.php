@component('mail::message')
# You're Registered!

Hi {{ $registration->full_name }},

Thank you for registering for the **High on Life, Not on Drugs Awareness Walk**, hosted by
DevEdge CBHA Foundation in collaboration with NDLEA.

**Reference Number:** {{ $registration->reference_number }}

**Date:** Saturday, 18th July 2026
**Time:** 9:00 AM
**Location:** To be confirmed
**Dress Code:** Comfortable walking shoes / campaign T-shirt if provided

Your walk ticket and venue details will be sent once registration goes live.

@component('mail::button', ['url' => config('app.url')])
Visit Event Page
@endcomponent

We look forward to walking with you.

Thanks,<br>
Development Edge for Capacity Building and Health Advancement Foundation<br>
in collaboration with the National Drug Law Enforcement Agency (NDLEA)
@endcomponent