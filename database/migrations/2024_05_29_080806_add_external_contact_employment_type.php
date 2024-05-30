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
        Schema::table('external_contacts', function (Blueprint $table) {
            $table->unsignedBigInteger('employment_type')->nullable();
            $table->foreign('employment_type')->references('id')->on('employment_types')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('external_contacts', function (Blueprint $table) {
            $table->dropColumn('employment_type');
        });
    }
};
