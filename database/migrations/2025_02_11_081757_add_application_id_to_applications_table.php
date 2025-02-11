<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Application;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::table('applications', function (Blueprint $table) {
            $table->bigInteger('application_id')->nullable()->unique()->after('id'); // Numeric unique ID
        });

        // Generate unique numeric IDs for existing records
        foreach (Application::whereNull('application_id')->get() as $application) {
            $application->update(['application_id' => $this->generateUniqueApplicationId()]);
        }

        // Make the column non-nullable after updating existing records
        Schema::table('applications', function (Blueprint $table) {
            $table->bigInteger('application_id')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::table('applications', function (Blueprint $table) {
            $table->dropColumn('application_id');
        });
    }

    /**
     * Generate a unique numeric application ID
     */
    private function generateUniqueApplicationId(): int
    {
        do {
            $id = mt_rand(1000000000, 9999999999); // Generate a 10-digit unique number
        } while (Application::where('application_id', $id)->exists());

        return $id;
    }
};
