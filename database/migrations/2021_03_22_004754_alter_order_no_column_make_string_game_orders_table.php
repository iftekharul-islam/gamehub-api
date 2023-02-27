<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterOrderNoColumnMakeStringGameOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('game_orders', function (Blueprint $table) {
            $table->string('order_no')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('game_orders', function (Blueprint $table) {
            $table->unsignedBigInteger('order_no')->change();
        });
    }
}
