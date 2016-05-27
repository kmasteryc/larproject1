<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlaylists extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('playlists', function (Blueprint $table) {
            $table->increments('id');
			$table->string('playlist_title');
			$table->integer('playlist_view')->default(0);

			$table->integer('cate_id')->unsigned();
			$table->integer('user_id')->unsigned();

			$table->foreign('cate_id')->references('id')->on('cates')->onDelete('cascade');
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::drop('playlists');
    }
}
