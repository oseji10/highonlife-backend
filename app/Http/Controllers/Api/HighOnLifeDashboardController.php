<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AwarenessWalkRegistration;
use App\Models\LivingRoomRegistration;
use Illuminate\Support\Facades\DB;

class HighOnLifeDashboardController extends Controller
{
    private const AGE_RANGES = ['Under 18', '18-24', '25-30', '31-40', 'Above 40'];

    private const LIVING_ROOM_GENDERS = ['Female', 'Male', 'Prefer not to say'];

    private const LIVING_ROOM_DESCRIPTIONS = [
        'Student',
        'Young professional',
        'Entrepreneur',
        'Volunteer',
        'Creative',
        'NGO / Development sector worker',
        'Health professional',
        'Educator',
        'Government / Public sector representative',
        'Media',
        'Other',
    ];

    private const LIVING_ROOM_HEAR_ABOUT = [
        'Instagram', 'WhatsApp', 'Friend/Family', 'School', 'Organisation', 'Invitation', 'Other',
    ];

    private const PHOTO_CONSENT = ['Yes', 'No'];

    private const REGISTERING_AS = [
        'An Individual', 'Part of a school', 'Part of an organisation/group', 'Volunteer', 'Other',
    ];

    private const TSHIRT_SIZES = ['XS', 'S', 'M', 'L', 'XL', 'XXL', 'XXXL', 'Other'];

    public function index()
    {
        return response()->json([
            'data' => [
                'livingRoom' => $this->livingRoomSummary(),
                'awarenessWalk' => $this->awarenessWalkSummary(),
            ],
        ]);
    }

    private function livingRoomSummary(): array
    {
        return [
            'totalRegistrations' => LivingRoomRegistration::count(),
            'capacity' => (int) config('high_on_life.living_room_capacity'),
            'attendingYes' => LivingRoomRegistration::where('attending', 'Yes')->count(),
            'attendingMaybe' => LivingRoomRegistration::where('attending', 'Maybe')->count(),
            'ageRangeBreakdown' => $this->breakdown(LivingRoomRegistration::class, 'age_range', self::AGE_RANGES),
            'genderBreakdown' => $this->breakdown(LivingRoomRegistration::class, 'gender', self::LIVING_ROOM_GENDERS),
            'descriptionBreakdown' => $this->breakdown(LivingRoomRegistration::class, 'description', self::LIVING_ROOM_DESCRIPTIONS),
            'hearAboutBreakdown' => $this->breakdown(LivingRoomRegistration::class, 'hear_about', self::LIVING_ROOM_HEAR_ABOUT),
            'photoConsentBreakdown' => $this->breakdown(LivingRoomRegistration::class, 'photo_consent', self::PHOTO_CONSENT),
            'recentRegistrations' => $this->recent(LivingRoomRegistration::class),
        ];
    }

    private function awarenessWalkSummary(): array
    {
        return [
            'totalRegistrations' => AwarenessWalkRegistration::count(),
            'capacity' => (int) config('high_on_life.awareness_walk_capacity'),
            'attendingYes' => AwarenessWalkRegistration::where('attending', 'Yes')->count(),
            'attendingMaybe' => AwarenessWalkRegistration::where('attending', 'Maybe')->count(),
            'ageRangeBreakdown' => $this->breakdown(AwarenessWalkRegistration::class, 'age_range', self::AGE_RANGES),
            'registeringAsBreakdown' => $this->breakdown(AwarenessWalkRegistration::class, 'registering_as', self::REGISTERING_AS),
            'tshirtSizeBreakdown' => $this->breakdown(AwarenessWalkRegistration::class, 'tshirt_size', self::TSHIRT_SIZES),
            'recentRegistrations' => $this->recent(AwarenessWalkRegistration::class),
        ];
    }

    /**
     * Build a { label, count } breakdown for a given column, preserving the
     * full ordered list of possible labels (including zero counts) so charts
     * always show every category even before any registrations pick it.
     */
    private function breakdown(string $modelClass, string $column, array $orderedLabels): array
    {
        $counts = $modelClass::query()
            ->select($column, DB::raw('count(*) as aggregate_count'))
            ->groupBy($column)
            ->pluck('aggregate_count', $column);

        return collect($orderedLabels)
            ->map(fn ($label) => [
                'label' => $label,
                'count' => (int) ($counts[$label] ?? 0),
            ])
            ->values()
            ->all();
    }

    /**
     * Most recent registrations for the dashboard's activity table.
     */
    private function recent(string $modelClass, int $limit = 8): array
    {
        return $modelClass::query()
            ->latest()
            ->limit($limit)
            ->get()
            ->map(fn ($registration) => [
                'referenceNumber' => $registration->reference_number,
                'fullName' => $registration->full_name,
                'email' => $registration->email,
                'attending' => $registration->attending,
                'createdAt' => $registration->created_at->format('d M Y, h:ia'),
            ])
            ->all();
    }
}