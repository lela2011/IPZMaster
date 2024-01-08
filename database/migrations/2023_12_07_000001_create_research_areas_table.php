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
        Schema::create('research_areas', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('english');
            $table->string('german');
            $table->string('english_url');
            $table->string('german_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('research_areas');
    }
};
