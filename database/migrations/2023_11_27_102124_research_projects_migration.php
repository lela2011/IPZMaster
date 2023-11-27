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
            $table->boolean('finished');
            $table->string('title');
            $table->string('title_original')->nullable();
            $table->longText('summary')->nullable();
            $table->string('summary_url')->nullable();
            $table->string('publication_textentry_list')->nullable();
            $table->text('publication_zora_id_list')->nullable();
            $table->string('publication_zora_text_list')->nullable();
            $table->string('publication_url')->nullable();
            $table->text('keyword_list')->nullable();
            $table->text('project_url_list')->nullable();
            $table->text('funding_list')->nullable();
            $table->text('collaborating_institutions')->nullable();
            $table->text('collaborating_counties')->nullable();
            $table->string('project_owner');
            $table->text('project_leaders');
            $table->text('project_members')->nullable();
            $table->text('contact_list')->nullable();
            $table->string('transv_research_prio')->nullable();
            $table->time('project_start');
            $table->time('project_end');
            $table->timestamps();
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
