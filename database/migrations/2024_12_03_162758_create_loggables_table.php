<?php

use App\Enums\LogLevelEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Activitylog\Models\Activity;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('loggables', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Activity::class)->unsigned()->index()->nullable();
            $table->unsignedBigInteger('loggable_id')->index();
            $table->string('loggable_type');
            $table->tinyInteger('level')->default(LogLevelEnum::LOW->value);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loggables');
    }
};
