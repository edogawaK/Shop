<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use SebastianBergmann\Type\NullType;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('product_size', function (Blueprint $table) {
        //     $table->unsignedInteger('product_id');
        //     $table->unsignedInteger('size_id');
        //     $table->integer('amount');

        //     $table->primary(['product_id','size_id']);
        //     $table->foreign('product_id')->references('product_id')->on('product');
        //     $table->foreign('size_id')->references('size_id')->on('size');
        // });

        Schema::create('admin', function (Blueprint $table) {
            $table->increments('admin_id');
            $table->string('admin_name');
            $table->string('admin_phone');
            $table->string('admin_email')->unique();
            $table->string('admin_password');
            $table->integer('admin_role')->default(1);
            $table->integer('admin_status')->default(1);
        });

        Schema::create('locate', function (Blueprint $table) {
            $table->increments('locate_id');
            $table->integer('locate_city');
            $table->integer('locate_ward');
            $table->integer('locate_district');
            $table->string('locate_street');
            $table->string('locate_receiver');
            $table->string('locate_phone');
            $table->integer('locate_status')->default(1);
        });

        Schema::create('user', function (Blueprint $table) {
            $table->increments('user_id');
            $table->string('user_name');
            $table->string('user_password');
            $table->string('user_email')->unique();
            $table->integer('user_status')->default(1);
            $table->double('user_point')->default(100);
            $table->unsignedInteger('locate_id');

            $table->foreign('locate_id')->references('locate_id')->on('locate');
        });

        Schema::create('sale', function (Blueprint $table) {
            $table->increments('sale_id');
            $table->integer('sale_discount');
            $table->string('sale_name');
            $table->integer('sale_unit');
            $table->integer('sale_status')->default(1);
            $table->dateTime('sale_date')->useCurrent();
            $table->dateTime('sale_end');
            $table->unsignedInteger('admin_id');

            $table->foreign('admin_id')->references('admin_id')->on('admin');
        });

        Schema::create('category', function (Blueprint $table) {
            $table->increments('category_id');
            $table->string('category_name');
            $table->integer('category_status')->default(1);
            $table->unsignedInteger('category_parent')->nullable();
        });

        Schema::create('product', function (Blueprint $table) {
            $table->increments('product_id');
            $table->string('product_name');
            $table->string('product_avt');
            $table->double('product_price');
            $table->double('product_cost');
            $table->dateTime('product_date')->useCurrent();
            $table->integer('product_sold')->default(0);
            $table->text('product_desc');
            $table->integer('product_status')->default(1);
            $table->double('product_rate')->default(0);
            $table->unsignedInteger('sale_id')->nullable();
            $table->unsignedInteger('category_id');

            $table->foreign('sale_id')->references('sale_id')->on('sale');
            $table->foreign('category_id')->references('category_id')->on('category');
        });

        Schema::create('order', function (Blueprint $table) {
            $table->increments('order_id');
            $table->dateTime('order_date')->useCurrent();
            $table->dateTime('order_receive')->useCurrent();
            $table->double('order_ship');
            $table->double('order_total');
            $table->integer('order_status')->default(1);
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('locate_id');

            $table->foreign('user_id')->references('user_id')->on('user');
            $table->foreign('locate_id')->references('locate_id')->on('locate');
        });

        Schema::create('size', function (Blueprint $table) {
            $table->increments('size_id');
            $table->string('size_name');
            $table->integer('size_status')->default(1);
        });

        

        Schema::create('image', function (Blueprint $table) {
            $table->increments('image_id');
            $table->string('image_link');
            $table->unsignedInteger('product_id');

            $table->foreign('product_id')->references('product_id')->on('product');
        });

        Schema::create('product_size', function (Blueprint $table) {
            $table->unsignedInteger('product_id');
            $table->unsignedInteger('size_id');
            $table->integer('quantity');

            $table->primary(['product_id', 'size_id']);

            $table->foreign('product_id')->references('product_id')->on('product');
            $table->foreign('size_id')->references('size_id')->on('size');
        });

        

        // Schema::create('notification', function (Blueprint $table) {
        //     $table->increments('notification_id');
        //     $table->integer('notification_desc');
        //     $table->string('notification_status');
        //     $table->integer('notification_type');
        //     $table->integer('notification_date')->default(1);
        //     $table->dateTime('sale_date')->useCurrent();
        //     $table->dateTime('sale_end');
        //     $table->unsignedInteger('admin_id');

        //     $table->foreign('admin_id')->references('admin_id')->on('admin');
        // });


        Schema::create('rate', function (Blueprint $table) {
            $table->increments('rate_id');
            $table->string('rate_content');
            $table->integer('rate_point');
            $table->dateTime('rate_date')->useCurrent();
            $table->unsignedInteger('product_id');

            $table->foreign('product_id')->references('product_id')->on('product');
        });

        Schema::create('order_detail', function (Blueprint $table) {
            $table->unsignedInteger('order_id');
            $table->unsignedInteger('product_id');
            $table->unsignedInteger('size_id');
            $table->integer('quantity');

            $table->primary(['order_id','product_id','size_id']);

            $table->foreign('product_id')->references('product_id')->on('product');
            $table->foreign('size_id')->references('size_id')->on('size');
            $table->foreign('order_id')->references('order_id')->on('order');
        });

        Schema::create('cart', function (Blueprint $table) {
            $table->increments('cart_id');
            $table->integer('cart_quantity');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('product_id');
            $table->unsignedInteger('size_id');

            $table->foreign('product_id')->references('product_id')->on('product');
            $table->foreign('size_id')->references('size_id')->on('size');
            $table->foreign('user_id')->references('user_id')->on('user');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('admin');
        Schema::dropIfExists('user');
        Schema::dropIfExists('product');
        Schema::dropIfExists('locate');
        Schema::dropIfExists('cart');
        Schema::dropIfExists('order');
        Schema::dropIfExists('order_detail');
        Schema::dropIfExists('product_size');
        Schema::dropIfExists('image');
        Schema::dropIfExists('sale');
        Schema::dropIfExists('rate');
        Schema::dropIfExists('size');
        Schema::dropIfExists('category');
        Schema::enableForeignKeyConstraints();
    }
};
