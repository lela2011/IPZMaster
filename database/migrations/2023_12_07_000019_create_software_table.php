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
        Schema::create('software', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('manufacturer');
            $table->string('name')->nullable();
            $table->string('license_type')->nullable();
            $table->date('purchase_date')->nullable();
            $table->string('notes')->nullable();
            $table->string('invoice')->nullable();
            $table->unsignedBigInteger('supplier');
            $table->string('person');

            $table->foreign('manufacturer')->references('id')->on('manufacturers');
            $table->foreign('supplier')->references('id')->on('suppliers');
            $table->foreign('person')->references('uid')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('software');
    }
};
