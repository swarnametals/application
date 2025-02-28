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
        Schema::create('suppliers', function (Blueprint $table) {
            // Primary Key
            $table->id();

            // Supplier Details
            $table->string('supplier_name');
            $table->string('address');
            $table->string('phone_number');
            $table->string('email');
            $table->string('material_supplied');
            $table->string('tpin')->unique();

            // Timestamps
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};
