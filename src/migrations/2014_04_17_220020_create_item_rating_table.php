<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemRatingTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('item_ratings', function($table)
		{
		    $table->increments('id');
		    $table->integer('item_id');
		    $table->tinyInteger('score')->default('1');
		    $table->timestamp('added_on');
		    $table->string('ip_address');

		    
		    $table->index('item_id');
		    $table->index('ip_address');

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('item_ratings');
	}

}
