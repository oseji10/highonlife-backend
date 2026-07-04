<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AwarenessWalkRegistrationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'referenceNumber' => $this->reference_number,
            'fullName' => $this->full_name,
            'email' => $this->email,
            'phoneNumber' => $this->phone_number,
            'ageRange' => $this->age_range,
            'registeringAs' => $this->registering_as,
            'groupName' => $this->group_name,
            'attending' => $this->attending,
            'emergencyContactName' => $this->emergency_contact_name,
            'emergencyContactPhone' => $this->emergency_contact_phone,
            'medicalConditions' => $this->medical_conditions,
            'tshirtSize' => $this->tshirt_size,
            'createdAt' => $this->created_at?->toIso8601String(),
        ];
    }
}