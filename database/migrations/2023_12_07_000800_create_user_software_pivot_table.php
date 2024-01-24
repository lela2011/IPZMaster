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
        Schema::create('user_software', function (Blueprint $table) {
            $table->string('user_id');
            $table->unsignedBigInteger('software_id');

            $table->foreign('user_id')->references('uid')->on('users')->onDelete('cascade');
            $table->foreign('software_id')->references('id')->on('softwares')->onDelete('cascade');

            $table->primary(['user_id', 'software_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_software_pivot');
    }
};
