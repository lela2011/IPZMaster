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
        Schema::create('research_projects', function (Blueprint $table) {
            $table->id();
            $table->boolean('publish')->default(false);
            $table->string('title');
            $table->string('title_original')->nullable();
            $table->longText('summary')->nullable();
            $table->string('summary_urls')->nullable();
            $table->text('zora_ids')->nullable();
            $table->string('publication_url')->nullable();
            $table->string('project_urls')->nullable();
            $table->string('fundings')->nullable();
            $table->string('institutions')->nullable();
            $table->string('countrys')->nullable();
            $table->string('keywords')->nullable();
            $table->date('start_date');
            $table->date('end_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('research_projects');
    }
};
