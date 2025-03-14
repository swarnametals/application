<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up() {
        Schema::create('equipments', function (Blueprint $table) {
            $table->id();
            $table->string('asset_code')->nullable();
            $table->string('registration_number')->nullable();
            $table->string('chassis_number')->unique()->nullable();
            $table->string('engine_number')->unique()->nullable();
            $table->string('type');
            $table->string('ownership');
            $table->string('equipment_name');
            $table->date('date_purchased');
            $table->decimal('value', 10, 2);
            $table->json('pictures')->nullable(); // Stores array of picture URLs
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipments');
    }
};
