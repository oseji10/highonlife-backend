<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('awareness_walk_registrations', function (Blueprint $table) {
            $table->id();
            $table->string('reference_number')->unique();

            $table->string('full_name');
            $table->string('phone_number');
            $table->string('email');

            $table->enum('age_range', [
                'Under 18',
                '18-24',
                '25-30',
                '31-40',
                'Above 40',
            ]);

            $table->enum('registering_as', [
                'An Individual',
                'Part of a school',
                'Part of an organisation/group',
                'Volunteer',
                'Other',
            ]);

            $table->string('group_name')->nullable();

            $table->enum('attending', ['Yes', 'Maybe']);

            $table->string('emergency_contact_name');
            $table->string('emergency_contact_phone');
            $table->text('medical_conditions');

            $table->enum('tshirt_size', [
                'XS', 'S', 'M', 'L', 'XL', 'XXL', 'XXXL', 'Other',
            ]);

            $table->timestamp('confirmation_sent_at')->nullable();

            $table->timestamps();

            $table->index('email');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('awareness_walk_registrations');
    }
};