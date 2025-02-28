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
        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('equipment_id')->constrained('equipments')->onDelete('cascade');
            $table->foreignId('driver_id')->nullable()->constrained('employees')->nullOnDelete();
            $table->integer('trip_number');
            $table->date('departure_date');
            $table->date('return_date')->nullable();
            $table->integer('start_kilometers');
            $table->integer('end_kilometers')->nullable();
            $table->string('material_delivered')->nullable();
            $table->string('location');
            $table->decimal('quantity', 8, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trips');
    }
};
