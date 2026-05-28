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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('service_name');
            $table->text('service_description')->nullable();
            $table->decimal('price', 8, 2);
            $table->timestamps();

            $table->unsignedBigInteger('invoice_item_id');
                        $table->unsignedBigInteger('category_id');

            $table->foreign('invoice_item_id')->references('id')->on('invoice_items')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('category')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
