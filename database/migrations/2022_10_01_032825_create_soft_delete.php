<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('order', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('size', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('category', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('admin', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('product', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('order', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('size', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('category', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('admin', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('product', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
