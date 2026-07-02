<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAwarenessWalkRegistrationRequest;
use App\Http\Resources\AwarenessWalkRegistrationResource;
use App\Mail\AwarenessWalkRegistrationConfirmation;
use App\Models\AwarenessWalkRegistration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class AwarenessWalkRegistrationController extends Controller
{
    /**
     * Maximum number of registrations accepted for this event.
     * Once this is reached, no further applications are collected.
     */
    private const CAPACITY = 100;

    public function store(StoreAwarenessWalkRegistrationRequest $request)
    {
        // Lock the table while we check + insert so two simultaneous submissions
        // near the cap can't both slip through and push the count past capacity.
        $registration = DB::transaction(function () use ($request) {
            $currentCount = AwarenessWalkRegistration::query()->lockForUpdate()->count();

            if ($currentCount >= self::CAPACITY) {
                return null;
            }

            $attributes = $request->toModelAttributes();
            $attributes['reference_number'] = AwarenessWalkRegistration::generateReferenceNumber();

            return AwarenessWalkRegistration::create($attributes);
        });

        if (! $registration) {
            return response()->json([
                'success' => false,
                'message' => 'Registration for the Awareness Walk is now closed — we\'ve reached full capacity. Thank you for your interest.',
            ], 422);
        }

        try {
           \Log::info('Sending with BCC', ['bcc' => config('mail.admin_notification_address')]);

Mail::to($registration->email)
    ->bcc(config('mail.admin_notification_address'))
    ->send(new AwarenessWalkRegistrationConfirmation($registration));
    
            $registration->update(['confirmation_sent_at' => now()]);
        } catch (\Throwable $e) {
            // Don't fail the registration if the email fails to send —
            // log it so it can be resent manually or via a retry job.
            report($e);
        }

        return response()->json([
            'success' => true,
            'message' => 'Registration successful! Check your email for confirmation.',
            'data' => new AwarenessWalkRegistrationResource($registration),
        ], 201);
    }
}