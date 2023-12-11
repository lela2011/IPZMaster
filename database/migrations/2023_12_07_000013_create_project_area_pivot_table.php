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
        Schema::create('project_area', function (Blueprint $table) {
            $table->unsignedBigInteger('project_id');
            $table->string('area_id');

            $table->foreign('project_id')->references('id')->on('research_projects')->onDelete('cascade');
            $table->foreign('area_id')->references('id')->on('research_areas')->onDelete('cascade');

            $table->primary(['project_id', 'area_id'], 'primary_project_area');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_area');
    }
};
