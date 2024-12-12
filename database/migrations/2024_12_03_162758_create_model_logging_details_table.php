<?php

use App\Enums\LogLevelEnum;
use App\Enums\LogDetailsAsModelEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('model_record_log_settings', function (Blueprint $table) {
            $table->id();
            $table->morphs('model');
            $table->boolean('is_enabled')->default(false);
            $table->tinyInteger('logging_level')->default(LogLevelEnum::HIGH->value);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('model_record_log_settings');
    }
};
