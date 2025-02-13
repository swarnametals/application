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
        Schema::create('vehicle_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_id')->constrained()->onDelete('cascade');
            $table->date('departure_date'); // Date when the trip starts
            $table->date('return_date')->nullable(); // Date when the trip ends
            $table->integer('start_kilometers');
            $table->integer('end_kilometers')->nullable();
            $table->string('material_delivered')->nullable();
            $table->string('location');
            $table->decimal('quantity', 8, 2)->nullable(); // Quantity of material delivered
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicle_logs');
    }
};
