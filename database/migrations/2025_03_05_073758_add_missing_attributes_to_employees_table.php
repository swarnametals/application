<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->string('first_name')->after('user_id');
            $table->string('middle_name')->nullable()->after('first_name');
            $table->string('surname_name')->after('middle_name');
            $table->string('sex')->after('employee_full_name');
            $table->string('town')->after('address');
            $table->string('marital_status')->after('town');
            $table->date('date_of_birth')->nullable()->after('marital_status');
            $table->date('date_of_contract')->nullable()->after('date_of_joining');
            $table->date('date_of_termination_of_contract')->nullable()->after('date_of_contract');

            $table->string('nhima_identification_number')->nullable()->after('employee_id');

            $table->string('section')->after('department');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn([
                'first_name',
                'middle_name',
                'surname_name',
                'sex',
                'town',
                'marital_status',
                'date_of_birth',
                'date_of_contract',
                'date_of_termination_of_contract',
                'nhima_identification_number',
                'section',
            ]);
        });
    }
};
