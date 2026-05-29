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
        Schema::create('vaccination', function (Blueprint $table) {
            $table->id();
            $table->string('vaccine_name');
            $table->dateTime('date_given');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unsignedBigInteger('consultation_id');
            $table->unsignedBigInteger('medicine_id');

            $table->foreign('consultation_id')->references('id')->on('consultation')->onDelete('cascade');
            $table->foreign('medicine_id')->references('id')->on('medicine')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vaccination');
    }
};
