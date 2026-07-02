<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LivingRoomRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'reference_number',
        'full_name',
        'email',
        'phone_number',
        'age_range',
        'gender',
        'description',
        'attending',
        'hear_about',
        'photo_consent',
        'confirmation_sent_at',
    ];

    protected $casts = [
        'confirmation_sent_at' => 'datetime',
    ];

    /**
     * Generate the next sequential reference number, e.g. LRC-2026-000123.
     * Uses a row lock on the last record to avoid collisions under concurrent writes.
     */
    public static function generateReferenceNumber(): string
    {
        return \DB::transaction(function () {
            $year = now()->format('Y');

            $lastNumber = self::where('reference_number', 'like', "LRC-{$year}-%")
                ->lockForUpdate()
                ->orderByDesc('id')
                ->value('reference_number');

            $nextSequence = 1;

            if ($lastNumber) {
                $lastSequence = (int) substr($lastNumber, -6);
                $nextSequence = $lastSequence + 1;
            }

            return sprintf('LRC-%s-%06d', $year, $nextSequence);
        });
    }
}