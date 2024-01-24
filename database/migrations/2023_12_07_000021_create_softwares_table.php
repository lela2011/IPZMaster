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
        Schema::create('softwares', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('manufacturer')->nullable();
            $table->string('name')->nullable();
            $table->string('license_type')->nullable();
            $table->date('purchase_date')->nullable();
            $table->string('notes')->nullable();
            $table->string('invoice')->nullable();
            $table->unsignedBigInteger('supplier')->nullable();
            $table->unsignedInteger('quantity')->nullable();

            $table->foreign('manufacturer')->references('id')->on('manufacturers')->onDelete('set null');
            $table->foreign('supplier')->references('id')->on('suppliers')->onDelete('set null');
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
