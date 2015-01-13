<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCbtFeelingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cbt_feelings', function(Blueprint $table)
		{
			$table->bigInteger('id', true);
			$table->bigInteger('cbt_id')->index('cbt_id');
			$table->bigInteger('feeling_id')->index('feeling_id');
			$table->integer('intensity');
			$table->char('status', 1);
			$table->timestamps();
			$table->softDeletes();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('cbt_feelings');
	}

}
