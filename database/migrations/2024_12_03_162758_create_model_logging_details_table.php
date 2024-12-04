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
        Schema::create('model_logging_details', function (Blueprint $table) {
            $table->id();
            $table->morphs('model');
            $table->tinyInteger('details')->default(LogDetailsAsModelEnum::ENABLED->value);
            $table->tinyInteger('level')->default(LogLevelEnum::LOW->value);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('model_logging_details');
    }
};
