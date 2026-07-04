<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LivingRoomRegistrationResource extends JsonResource
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
            'gender' => $this->gender,
            'description' => $this->description,
            'attending' => $this->attending,
            'hearAbout' => $this->hear_about,
            'photoConsent' => $this->photo_consent,
            'createdAt' => $this->created_at?->toIso8601String(),
        ];
    }
}