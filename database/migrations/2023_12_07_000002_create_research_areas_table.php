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
            $table->longText('description_english')->nullable();
            $table->longText('description_german')->nullable();
            $table->longText('research_focus_english')->nullable();
            $table->longText('research_focus_german')->nullable();
            $table->string('teaching_english')->nullable();
            $table->string('teaching_german')->nullable();
            $table->string('support_english')->nullable();
            $table->string('support_german')->nullable();
            $table->string('url_english');
            $table->string('url_german');

            $table->string('manager_uid')->nullable()->unique();
            $table->foreign('manager_uid')->references('uid')->on('users')->onDelete('set null');
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
