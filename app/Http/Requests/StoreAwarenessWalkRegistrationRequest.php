<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class StoreAwarenessWalkRegistrationRequest extends FormRequest
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
            'phoneNumber' => ['required', 'string', 'min:8', 'max:20'],
            'email' => ['required', 'email', 'max:255'],

            'ageRange' => ['required', 'in:Under 18,18-24,25-30,31-40,Above 40'],

            'registeringAs' => ['required', 'in:An Individual,Part of a school,Part of an organisation/group,Volunteer,Other'],

            // Required only when registering with a school/organisation/group —
            // matches the conditional field shown on the frontend.
            'groupName' => ['nullable', 'required_if:registeringAs,Part of a school,Part of an organisation/group', 'string', 'max:255'],

            'attending' => ['required', 'in:Yes,Maybe'],

            'emergencyContactName' => ['required', 'string', 'max:255'],
            'emergencyContactPhone' => ['required', 'string', 'min:8', 'max:20'],
            'medicalConditions' => ['required', 'string', 'max:2000'],

            'tshirtSize' => ['required', 'in:XS,S,M,L,XL,XXL,XXXL,Other'],
        ];
    }

    public function messages(): array
    {
        return [
            'fullName.required' => 'Full name is required.',
            'phoneNumber.required' => 'Phone/WhatsApp number is required.',
            'phoneNumber.min' => 'Please enter a valid phone/WhatsApp number.',
            'email.required' => 'Email address is required.',
            'email.email' => 'Please enter a valid email address.',
            'ageRange.required' => 'Please select your age range.',
            'registeringAs.required' => "Please select how you're registering.",
            'groupName.required_if' => 'Please state the name of your school, organisation, or group.',
            'attending.required' => "Please let us know if you'll be attending.",
            'emergencyContactName.required' => 'Emergency contact name is required.',
            'emergencyContactPhone.required' => 'Emergency contact phone number is required.',
            'emergencyContactPhone.min' => 'Please enter a valid emergency contact phone number.',
            'medicalConditions.required' => 'Please enter any medical conditions, or "None" if not applicable.',
            'tshirtSize.required' => 'Please select a T-shirt size.',
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
            'phone_number' => $validated['phoneNumber'],
            'email' => $validated['email'],
            'age_range' => $validated['ageRange'],
            'registering_as' => $validated['registeringAs'],
            'group_name' => $validated['groupName'] ?? null,
            'attending' => $validated['attending'],
            'emergency_contact_name' => $validated['emergencyContactName'],
            'emergency_contact_phone' => $validated['emergencyContactPhone'],
            'medical_conditions' => $validated['medicalConditions'],
            'tshirt_size' => $validated['tshirtSize'],
        ];
    }
}