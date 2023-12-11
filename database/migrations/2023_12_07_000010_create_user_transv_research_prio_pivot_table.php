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
        Schema::create('user_transv_research_prio', function (Blueprint $table) {
            $table->string('user_id');
            $table->string('transv_research_prio_id');

            $table->foreign('user_id')->references('uid')->on('users')->onDelete('cascade');
            $table->foreign('transv_research_prio_id')->references('id')->on('transv_research_prios')->onDelete('cascade');

            $table->primary(['user_id', 'transv_research_prio_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_transv_research_prio');
    }
};
