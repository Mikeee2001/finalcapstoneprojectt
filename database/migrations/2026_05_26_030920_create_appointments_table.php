<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            // Appointment Schedule

            $table->date('requested_date');
            $table->time('requested_time');
            $table->date('appointment_date')->nullable();
            $table->time('appointment_time')->nullable();

            // Status
            $table->enum('status', [
                'pending',
                'approved',
                'completed',
                'cancelled'
            ])->default('pending');

            // Optional notes from user
            $table->text('notes')->nullable();

            // Relationships
            $table->foreignId('pet_id')->constrained('pets')->cascadeOnDelete();
            $table->foreignId('vet_id')->nullable()->constrained('veterinarian')->nullOnDelete();
            $table->foreignId('service_id')->constrained('services')->cascadeOnDelete();

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
