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
    public function index()
    {
        $registrations = LivingRoomRegistration::query()->latest()->get();

        return response()->json([
            'success' => true,
            'message' => 'Registrations retrieved successfully.',
            'data' => LivingRoomRegistrationResource::collection($registrations),
        ]);
    }

    public function store(StoreLivingRoomRegistrationRequest $request)
    {
        $capacity = (int) config('high_on_life.living_room_capacity');

        // Lock the table while we check + insert so two simultaneous submissions
        // near the cap can't both slip through and push the count past capacity.
        $registration = DB::transaction(function () use ($request, $capacity) {
            $currentCount = LivingRoomRegistration::query()->lockForUpdate()->count();

            if ($currentCount >= $capacity) {
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

        $this->sendConfirmation($registration);

        return response()->json([
            'success' => true,
            'message' => 'Registration successful! Check your email for confirmation.',
            'data' => new LivingRoomRegistrationResource($registration),
        ], 201);
    }

    public function resendTicket(LivingRoomRegistration $livingRoomRegistration)
    {
        $this->sendConfirmation($livingRoomRegistration);

        return response()->json([
            'success' => true,
            'message' => 'Ticket resent successfully.',
        ]);
    }

    public function destroy(LivingRoomRegistration $livingRoomRegistration)
    {
        $livingRoomRegistration->delete();

        return response()->json([
            'success' => true,
            'message' => 'Registration deleted successfully.',
        ]);
    }

    private function sendConfirmation(LivingRoomRegistration $registration): void
    {
        try {
            Mail::to($registration->email)
                ->bcc(config('mail.admin_notification_address'))
                ->send(new LivingRoomRegistrationConfirmation($registration));

            $registration->update(['confirmation_sent_at' => now()]);
        } catch (\Throwable $e) {
            // Don't fail the request if the email fails to send —
            // log it so it can be retried manually.
            report($e);
        }
    }
}