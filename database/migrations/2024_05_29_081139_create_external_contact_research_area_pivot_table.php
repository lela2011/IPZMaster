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
        Schema::create('external_contact_research_area', function (Blueprint $table) {
            $table->unsignedBigInteger('external_id');
            $table->unsignedBigInteger('research_area_id');

            $table->foreign('external_id')->references('id')->on('external_contacts')->onDelete('cascade');
            $table->foreign('research_area_id')->references('id')->on('research_areas')->onDelete('cascade');

            $table->primary(['external_id', 'research_area_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('external_contact_research_area');
    }
};
