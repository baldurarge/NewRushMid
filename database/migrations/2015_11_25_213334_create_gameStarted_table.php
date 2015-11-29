<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGameStartedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gameStarted', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('leader_id');
            $table->integer('second_id');
            $table->integer('third_id');
            $table->integer('fourth_id');
            $table->integer('fifth_id');
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
        Schema::drop('gameStarted');
    }
}
