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
            $table->boolean('follow_global_config')->default(false)->after('is_enabled');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('model_log_settings', function (Blueprint $table) {
            $table->dropColumn('follow_global_config');
        });
    }
};
