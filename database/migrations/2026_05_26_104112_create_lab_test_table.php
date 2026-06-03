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
        Schema::create('lab_test', function (Blueprint $table) {
            $table->id();
            $table->string('test_name');
            $table->text('description')->nullable();
            $table->string('results');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unsignedBigInteger('records_id');
            $table->unsignedBigInteger('serviced_id');


            $table->foreign('records_id')->references('id')->on('medical_records')->onDelete('cascade');
                $table->foreign('serviced_id')->references('id')->on('services')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lab_test');
    }
};
