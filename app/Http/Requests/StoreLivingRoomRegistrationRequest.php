<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLivingRoomRegistrationRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Public registration endpoint — no auth required to submit.
        return true;
    }

    public function rules(): array
    {
        return [
            'fullName' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phoneNumber' => ['required', 'string', 'min:8', 'max:20'],

            'ageRange' => ['required', 'in:Under 18,18-24,25-30,31-40,Above 40'],
            'gender' => ['required', 'in:Female,Male,Prefer not to say'],
            'description' => ['required', 'in:Student,Young professional,Entrepreneur,Volunteer,Creative,NGO / Development sector worker,Health professional,Educator,Government / Public sector representative,Media,Other'],
            'attending' => ['required', 'in:Yes,Maybe'],
            'hearAbout' => ['required', 'in:Instagram,WhatsApp,Friend/Family,School,Organisation,Invitation,Other'],
            'photoConsent' => ['required', 'in:Yes,No'],
        ];
    }

    public function messages(): array
    {
        return [
            'fullName.required' => 'Full name is required.',
            'email.required' => 'Email address is required.',
            'email.email' => 'Please enter a valid email address.',
            'phoneNumber.required' => 'Phone/WhatsApp number is required.',
            'phoneNumber.min' => 'Please enter a valid phone/WhatsApp number.',
            'ageRange.required' => 'Please select your age range.',
            'gender.required' => 'Please select an option.',
            'description.required' => 'Please select the option that best describes you.',
            'attending.required' => "Please let us know if you'll be attending.",
            'hearAbout.required' => 'Please select how you heard about this event.',
            'photoConsent.required' => 'Please indicate your consent.',
        ];
    }

    /**
     * Map validated camelCase input to snake_case columns for the model.
     */
    public function toModelAttributes(): array
    {
        $validated = $this->validated();

        return [
            'full_name' => $validated['fullName'],
            'email' => $validated['email'],
            'phone_number' => $validated['phoneNumber'],
            'age_range' => $validated['ageRange'],
            'gender' => $validated['gender'],
            'description' => $validated['description'],
            'attending' => $validated['attending'],
            'hear_about' => $validated['hearAbout'],
            'photo_consent' => $validated['photoConsent'],
        ];
    }
}