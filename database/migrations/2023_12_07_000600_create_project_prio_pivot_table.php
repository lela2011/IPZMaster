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
        Schema::create('project_prio', function (Blueprint $table) {
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('prio_id');

            $table->foreign('project_id')->references('id')->on('research_projects')->onDelete('cascade');
            $table->foreign('prio_id')->references('id')->on('transv_research_prios')->onDelete('cascade');

            $table->primary(['project_id', 'prio_id'], 'primary_project_prio');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_prio');
    }
};
