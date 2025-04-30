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
            $table->enum('status', ['read', 'unread'])->default('unread')->after('suggest_description');
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
