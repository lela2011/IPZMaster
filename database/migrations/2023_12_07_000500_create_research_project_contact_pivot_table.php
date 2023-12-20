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
        Schema::create('research_project_contact', function (Blueprint $table) {
            $table->unsignedBigInteger('research_project_id');
            $table->string('user_id')->nullable();
            $table->unsignedBigInteger('external_contact_id')->nullable();

            $table->foreign('research_project_id')->references('id')->on('research_projects')->onDelete('cascade');
            $table->foreign('user_id')->references('uid')->on('users')->onDelete('cascade');
            $table->foreign('external_contact_id')->references('id')->on('external_contacts')->onDelete('cascade');

            $table->unique(['research_project_id', 'user_id', 'external_contact_id'], 'unique_project_contacts');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('research_project_contact');
    }
};
