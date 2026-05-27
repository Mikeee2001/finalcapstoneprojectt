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
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->string('batch_number')->nullable();
            $table->integer('quantity');
            $table->decimal('unit_cost', 10, 2);
            $table->date('expiration_date');
            $table->timestamps();

            $table->unsignedBigInteger('medicine_id');
            $table->unsignedBigInteger('supplier_id');

            $table->foreign('medicine_id')->references('id')->on('medicine')->onDelete('cascade');
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventories');
    }
};
