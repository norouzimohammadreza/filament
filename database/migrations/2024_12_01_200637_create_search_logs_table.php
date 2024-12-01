<?php

use App\Models\User;
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
        Schema::create('search_logs', function (Blueprint $table) {
            $table->id();
            $table->string('resource');
            $table->string('search_query');
            $table->foreignIdFor(User::class)->index();
            $table->timestamps();
        });
        $this->iplog();
    }
    public function iplog(): void{
        DB::statement('ALTER TABLE `search_logs` ADD `ip` VARBINARY(16) AFTER `id`');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('search_logs');
    }
};
