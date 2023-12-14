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
            $table->string('title', 1000);
            $table->string('title_original', 1000)->nullable();
            $table->longText('summary')->nullable();
            $table->string('summary_urls', 1000)->nullable();
            $table->string('zora_ids', 1000)->nullable();
            $table->string('publication_url', 500)->nullable();
            $table->string('project_urls', 1000)->nullable();
            $table->string('fundings', 1000)->nullable();
            $table->string('institutions', 1000)->nullable();
            $table->string('countrys', 1000)->nullable();
            $table->string('contributors', 1000)->nullable();
            $table->string('keywords', 1000)->nullable();
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
