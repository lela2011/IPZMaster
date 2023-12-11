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
        // defines the table structure of Transversal Research Priorities Table
        Schema::create('transv_research_prios', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('english');
            $table->string('german');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // drops table on migration refresh
        Schema::dropIfExists('transv_research_prios');
    }
};
