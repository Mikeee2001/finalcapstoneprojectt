<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('prescription', function (Blueprint $table) {
            $table->id();
            $table->dateTime('prescription_date');
            $table->text('notes')->nullable();
            $table->string('recommendations')->nullable();
            $table->timestamps();

            $table->unsignedBigInteger('consultation_id');
            $table->unsignedBigInteger('veterinarian_id');

            $table->foreign('consultation_id')->references('id')->on('consultation')->onDelete('cascade');
            $table->foreign('veterinarian_id')->references('id')->on('veterinarian')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prescription');
    }
};
