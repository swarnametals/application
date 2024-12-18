<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('id_number')->unique();
            $table->string('position');
            $table->string('grade');
            $table->string('team');
            $table->decimal('basic_salary', 10, 2);
            $table->decimal('housing_allowance', 10, 2)->default(0);
            $table->decimal('transport_allowance', 10, 2)->default(0);
            $table->decimal('other_allowances', 10, 2)->default(0);
            $table->decimal('lunch_allowance', 10, 2)->default(0);
            $table->decimal('loan_recovery', 10, 2)->default(0);
            $table->decimal('other_deductions', 10, 2)->default(0);
            $table->string('payment_method');
            $table->string('social_security_number');
            $table->string('bank_account_number')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
