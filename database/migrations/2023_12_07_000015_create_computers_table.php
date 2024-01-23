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
        Schema::create('computers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('type')->nullable();
            $table->unsignedBigInteger('manufacturer')->nullable();
            $table->string('model')->nullable();
            $table->string('serial_number')->nullable();
            $table->string('product_number')->nullable();
            $table->string('mac_address')->nullable();
            $table->string('network_name')->nullable();
            $table->unsignedBigInteger('operating_system')->nullable();
            $table->string('cpu')->nullable();
            $table->string('ram')->nullable();
            $table->string('storage')->nullable();
            $table->unsignedBigInteger('location')->nullable();
            $table->date('purchase_date')->nullable();
            $table->date('warranty_date')->nullable();
            $table->string('notes')->nullable();
            $table->string('invoice')->nullable();
            $table->unsignedBigInteger('supplier')->nullable();
            $table->string('person')->nullable();

            $table->foreign('type')->references('id')->on('computer_types')->onDelete('set null');
            $table->foreign('manufacturer')->references('id')->on('manufacturers')->onDelete('set null');
            $table->foreign('operating_system')->references('id')->on('operating_systems')->onDelete('set null');
            $table->foreign('location')->references('id')->on('locations')->onDelete('set null');
            $table->foreign('supplier')->references('id')->on('suppliers')->onDelete('set null');
            $table->foreign('person')->references('uid')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('computers');
    }
};
