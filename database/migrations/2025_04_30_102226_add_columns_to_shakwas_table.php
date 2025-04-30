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
        Schema::table('shakwas', function (Blueprint $table) {
            $table->foreignId('event_id')->after('user_id')->nullable()->constrained('events')->onDelete('cascade');
            $table->foreignId('task_id')->after('event_id')->nullable()->constrained('tasks')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shakwas', function (Blueprint $table) {
            //
        });
    }
};
