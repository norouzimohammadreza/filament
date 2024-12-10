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
        Schema::create('model_as_log', function (Blueprint $table) {
            $table->id();
            $table->string('model');
            $table->tinyInteger('details')->default(LogDetailsAsModelEnum::ENABLED->value);
            $table->tinyInteger('level')->default(LogLevelEnum::HIGH->value);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('model_logging');
    }
};
