<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfirumTable extends Migration {

	public function up()
	{
        Schema::create('confirm_user', function(Blueprint $table)
        {
            $table->engine = 'InnoDB';

            $table->increments('id');

            $table->integer('user_id')->unsigned()->index();

            $table->string('hash')->index();
            $table->string('action')->index();
            $table->mediumText('config');
            $table->timestamps();

            $table->unique(array('user_id', 'action'), 'user_action');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
	}

	public function down()
	{
        Schema::drop('confirm_user');
	}

}
