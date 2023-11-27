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
        Schema::create('user_competence', function (Blueprint $table) {
            $table->string('foreign_uid');
            $table->string('foreign_competence');

            $table->foreign('foreign_uid')->references('uid')->on('users')->onDelete('cascade');
            $table->foreign('foreign_competence')->references('competence')->on('competences')->onDelete('cascade');

            $table->primary(['foreign_uid', 'foreign_competence']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_competence');
    }
};
