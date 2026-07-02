<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AwarenessWalkRegistrationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'referenceNumber' => $this->reference_number,
            'fullName' => $this->full_name,
            'email' => $this->email,
        ];
    }
}