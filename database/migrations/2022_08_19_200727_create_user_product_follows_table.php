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
        Schema::create('user_product_follows', function (Blueprint $table) {
            $table->id();

            $table->integer('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');

            $table->integer('product_id')->nullable();
            $table->foreign('product_id')->references('id')->on('products');

            $table->boolean('follow')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_product_follows');
    }
};
