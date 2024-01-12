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
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('orcid')->nullable();
            $table->string('website')->nullable();
            $table->longText('cv_english')->nullable();
            $table->longText('cv_german')->nullable();
            $table->longText('research_focus_english')->nullable();
            $table->longText('research_focus_german')->nullable();
            $table->boolean('media_mail')->default(false);
            $table->boolean('media_phone')->default(false);
            $table->boolean('media_secretariat')->default(false);
            $table->unsignedBigInteger('employment_type')->nullable();
            $table->string('password')->nullable();
            $table->integer('adminLevel')->default(0);
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('employment_type')->references('id')->on('employment_types')->onDelete('set null');
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
