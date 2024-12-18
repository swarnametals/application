<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::table('employees', function (Blueprint $table) {
            $table->decimal('overtime_hours', 10, 2)->nullable()->after('other_allowances');
            $table->decimal('overtime_pay', 10, 2)->nullable()->after('overtime_hours');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn('overtime_hours');
            $table->dropColumn('overtime_pay');
        });
    }
};
