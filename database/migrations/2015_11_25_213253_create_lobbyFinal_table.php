<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLobbyFinalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lobbyFinal', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('leader_id');
            $table->integer('second_id');
            $table->integer('third_id');
            $table->integer('forth_id');
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
        Schema::drop('lobbyFinal');
    }
}
