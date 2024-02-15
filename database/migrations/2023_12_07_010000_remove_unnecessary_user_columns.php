<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('users', function($table) {
            $table->dropColumn('remember_token');
            $table->dropColumn('password');
            $table->dropColumn('created_at');
            $table->dropColumn('updated_at');
        });
    }

    public function down()
    {
        Schema::table('users', function($table) {
            $table->rememberToken();
            $table->timestamps();
            $table->string('password')->nullable();
        });
    }
};
