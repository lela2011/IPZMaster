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
        Schema::create('user_research_project', function (Blueprint $table) {
            $table->string('user_id');
            $table->unsignedBigInteger('research_project_id');
            $table->string('role');

            $table->foreign('user_id')->references('uid')->on('users')->onDelete('cascade');
            $table->foreign('research_project_id')->references('id')->on('research_projects')->onDelete('cascade');

            $table->primary(['user_id', 'research_project_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_research_project');
    }
};
