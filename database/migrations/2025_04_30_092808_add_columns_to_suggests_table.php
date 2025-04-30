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
        Schema::table('suggests', function (Blueprint $table) {
            $table->foreignId('event_id')->nullable()->after('user_id')->constrained('events')->onDelete('cascade');
            $table->foreignId('task_id')->nullable()->after('event_id')->constrained('tasks')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('suggests', function (Blueprint $table) {
            //
        });
    }
};
