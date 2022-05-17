<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceiptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receipts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('cooking_hours');
            $table->integer('cooking_minutes');
            $table->string('main_img');
            $table->unsignedBigInteger('id_category');
            $table->unsignedBigInteger('id_kitchen');
            $table->unsignedBigInteger('id_user');
            $table->text('advice')->nullable();
            $table->timestamps();

            $table->foreign('id_kitchen')->references('id')->on('kitchens')->onDelete('cascade');
            $table->foreign('id_category')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('receipts');
    }
}
