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
        Schema::create('pets', function (Blueprint $table) {
            $table->id();
            $table->string('pet_name');
            $table->integer('age');
            $table->string('gender');
            $table->timestamps();
            $table->unsignedBigInteger('species_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('breed_id');

            $table->foreign('species_id')->references('id')->on('species')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('breed_id')->references('id')->on('breeds')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pets');
    }
};
