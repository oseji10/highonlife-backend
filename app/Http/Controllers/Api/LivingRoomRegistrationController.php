<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLivingRoomRegistrationRequest;
use App\Http\Resources\LivingRoomRegistrationResource;
use App\Mail\LivingRoomRegistrationConfirmation;
use App\Models\LivingRoomRegistration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class LivingRoomRegistrationController extends Controller
{
    /**
     * Maximum number of registrations accepted for this event.
     * Once this is reached, no further applications are collected.
     */
    private const CAPACITY = 50;

    public function store(StoreLivingRoomRegistrationRequest $request)
    {
        // Lock the table while we check + insert so two simultaneous submissions
        // near the cap can't both slip through and push the count past capacity.
        $registration = DB::transaction(function () use ($request) {
            $currentCount = LivingRoomRegistration::query()->lockForUpdate()->count();

            if ($currentCount >= self::CAPACITY) {
                return null;
            }

            $attributes = $request->toModelAttributes();
            $attributes['reference_number'] = LivingRoomRegistration::generateReferenceNumber();

            return LivingRoomRegistration::create($attributes);
        });

        if (! $registration) {
            return response()->json([
                'success' => false,
                'message' => 'Registration for The Living Room Conversation is now closed — we\'ve reached full capacity. Thank you for your interest.',
            ], 422);
        }

        try {
            \Log::info('Sending with BCC', ['bcc' => config('mail.admin_notification_address')]);
            Mail::to($registration->email)
                ->bcc(config('mail.admin_notification_address'))
                ->send(new LivingRoomRegistrationConfirmation($registration));

            $registration->update(['confirmation_sent_at' => now()]);
        } catch (\Throwable $e) {
            // Don't fail the registration if the email fails to send —
            // log it so it can be resent manually or via a retry job.
            report($e);
        }

        return response()->json([
            'success' => true,
            'message' => 'Registration successful! Check your email for confirmation.',
            'data' => new LivingRoomRegistrationResource($registration),
        ], 201);
    }
}