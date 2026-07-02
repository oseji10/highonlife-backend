<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('living_room_registrations', function (Blueprint $table) {
            $table->id();
            $table->string('reference_number')->unique();

            $table->string('full_name');
            $table->string('email');
            $table->string('phone_number');

            $table->enum('age_range', [
                'Under 18',
                '18-24',
                '25-30',
                '31-40',
                'Above 40',
            ]);

            $table->enum('gender', [
                'Female',
                'Male',
                'Prefer not to say',
            ]);

            $table->enum('description', [
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
            ]);

            $table->enum('attending', ['Yes', 'Maybe']);

            $table->enum('hear_about', [
                'Instagram',
                'WhatsApp',
                'Friend/Family',
                'School',
                'Organisation',
                'Invitation',
                'Other',
            ]);

            $table->enum('photo_consent', ['Yes', 'No']);

            $table->timestamp('confirmation_sent_at')->nullable();

            $table->timestamps();

            $table->index('email');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('living_room_registrations');
    }
};