<?php

use App\Enums\LogDetailsAsModelEnum;
use App\Enums\LogLevelEnum;
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
        Schema::create('model_log_settings', function (Blueprint $table) {
            $table->id();
            $table->string('model_type');
            $table->boolean('is_enabled')->default(false);
            $table->tinyInteger('logging_level')->default(LogLevelEnum::HIGH->value);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('model_log_settings');
    }
};
