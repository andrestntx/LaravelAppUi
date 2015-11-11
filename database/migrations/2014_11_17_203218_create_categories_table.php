<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('categories', function($table)
		{
		    $table->increments('id');
		    $table->string('name', 45);
		    $table->text('description')->nullable();	    

		    $table->integer('user_id')->unsigned();
		    $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade');

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
		Schema::drop('categories');
	}

}
