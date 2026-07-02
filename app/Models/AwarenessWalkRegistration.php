<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AwarenessWalkRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'reference_number',
        'full_name',
        'phone_number',
        'email',
        'age_range',
        'registering_as',
        'group_name',
        'attending',
        'emergency_contact_name',
        'emergency_contact_phone',
        'medical_conditions',
        'tshirt_size',
        'confirmation_sent_at',
    ];

    protected $casts = [
        'confirmation_sent_at' => 'datetime',
    ];

    /**
     * Generate the next sequential reference number, e.g. AW-2026-000123.
     * Uses a row lock on the last record to avoid collisions under concurrent writes.
     */
    public static function generateReferenceNumber(): string
    {
        return \DB::transaction(function () {
            $year = now()->format('Y');

            $lastNumber = self::where('reference_number', 'like', "AW-{$year}-%")
                ->lockForUpdate()
                ->orderByDesc('id')
                ->value('reference_number');

            $nextSequence = 1;

            if ($lastNumber) {
                $lastSequence = (int) substr($lastNumber, -6);
                $nextSequence = $lastSequence + 1;
            }

            return sprintf('AW-%s-%06d', $year, $nextSequence);
        });
    }
}