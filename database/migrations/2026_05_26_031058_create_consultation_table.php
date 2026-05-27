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
        Schema::create('consultation', function (Blueprint $table) {
            $table->id();
            $table->text('diagnosis');
            $table->text('symptoms');
            $table->text('findings');
            $table->text('treatment');
            $table->timestamps();

            $table->unsignedBigInteger('vet_id')->unique();
            $table->unsignedBigInteger('appointment_id')->unique();
            $table->unsignedBigInteger('service_id');

            $table->foreign('vet_id')->references('id')->on('veterinarian')->onDelete('cascade');
            $table->foreign('appointment_id')->references('id')->on('appointments')->onDelete('cascade');
            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultation');
    }
};
