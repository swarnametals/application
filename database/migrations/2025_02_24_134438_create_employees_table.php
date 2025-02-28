<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up() {
        Schema::create('employees', function (Blueprint $table) {
            // Primary Key
            $table->id();

            // Foreign Key to Users Table
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');

            // Employee Details
            $table->string('employee_full_name');
            $table->string('phone_number')->nullable();
            $table->string('email')->nullable();
            $table->string('address');
            $table->string('nationality');
            $table->date('date_of_joining');
            $table->string('employee_id')->unique();
            $table->string('tpin_number')->nullable();
            $table->string('nrc_or_passport_number');

            // Job Details
            $table->string('designation');
            $table->string('department');
            $table->string('grade')->nullable();

            // Salary Details
            $table->decimal('basic_salary', 10, 2);
            $table->decimal('housing_allowance', 10, 2)->default(0);
            $table->decimal('transport_allowance', 10, 2)->default(0);
            $table->decimal('other_allowances', 10, 2)->nullable();
            $table->decimal('food_allowance', 10, 2)->default(0);

            // References (JSON)
            $table->json('references')->nullable(); // Array of last employer references: name and phone number

            // Payment Details
            $table->string('payment_method');
            $table->string('social_security_number')->nullable();

            // Bank Details
            $table->string('account_name')->nullable();
            $table->string('ifsc_code')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('branch_name')->nullable();
            $table->string('bank_address')->nullable();
            $table->string('bank_telephone_number')->nullable();
            $table->string('bank_account_number')->nullable();

            // Timestamps
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
};
