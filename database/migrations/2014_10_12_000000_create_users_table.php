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
        // defines the table structure of Users-Table
        Schema::create('users', function (Blueprint $table) {
            $table->string('uid')->primary();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('orcid')->nullable();
            $table->string('research_areas')->default('default');
            $table->string('transv_research_prio')->nullable();
            $table->longText('cv')->nullable();
            $table->string('password')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // drops table on migration refresh
        Schema::dropIfExists('users');
    }
};
