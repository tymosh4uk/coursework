<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIngradientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingradients', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_receipt');
            $table->string('ingradient');
            $table->integer('count_ingradient')->nullable();
            $table->string('type_measuring');
            $table->timestamps();

            $table->foreign('id_receipt')->references('id')->on('receipts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ingradients');
    }
}
