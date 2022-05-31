<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameReceiptLikesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('receipt_likes', function (Blueprint $table) {
            $table->renameColumn('id_user','user_id');
            $table->renameColumn('id_receipt','receipt_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('receipt_likes', function (Blueprint $table) {
            $table->renameColumn('user_id','id_user');
            $table->renameColumn('receipt_id','id_receipt');
        });
    }
}
