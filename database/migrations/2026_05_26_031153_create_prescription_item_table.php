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
        Schema::create('prescription_item', function (Blueprint $table) {
            $table->id();
            $table->string('dosage')->nullable();
            $table->string('frequency')->nullable();
            $table->string('days')->nullable();
            $table->string('instructions')->nullable();
            $table->integer('quantity');
            $table->timestamps();

            $table->unsignedBigInteger('prescription_id');
            $table->unsignedBigInteger('medicine_id');

            $table->foreign('prescription_id')->references('id')->on('prescription')->onDelete('cascade');
            $table->foreign('medicine_id')->references('id')->on('medicine')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prescription_item');
    }
};
