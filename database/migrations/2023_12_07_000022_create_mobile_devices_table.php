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
        Schema::create('mobile_devices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('type_id')->nullable();
            $table->unsignedBigInteger('manufacturer_id')->nullable();
            $table->string('model')->nullable();
            $table->string('serial_number')->nullable();
            $table->string('product_number')->nullable();
            $table->string('network_name')->nullable();
            $table->string('imei')->nullable();
            $table->unsignedBigInteger('operating_system_id')->nullable();
            $table->string('storage')->nullable();
            $table->string('color')->nullable();
            $table->unsignedBigInteger('location_id')->nullable();
            $table->date('purchase_date')->nullable();
            $table->date('warranty_date')->nullable();
            $table->string('notes')->nullable();
            $table->string('invoice')->nullable();
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->string('user_id')->nullable();

            $table->foreign('type_id')->references('id')->on('mobile_device_types')->onDelete('set null');
            $table->foreign('manufacturer_id')->references('id')->on('manufacturers')->onDelete('set null');
            $table->foreign('operating_system_id')->references('id')->on('operating_systems')->onDelete('set null');
            $table->foreign('location_id')->references('id')->on('locations')->onDelete('set null');
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('set null');
            $table->foreign('user_id')->references('uid')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mobile_devices');
    }
};
