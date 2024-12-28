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
        Schema::table('model_log_settings', function (Blueprint $table) {
            $table->boolean('respect_global_config')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('model_log_settings', function (Blueprint $table) {
            $table->dropColumn('respect_global_config');
        });
    }
};
