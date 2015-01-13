<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCbtThoughtsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cbt_thoughts', function(Blueprint $table)
		{
			$table->bigInteger('id', true);
			$table->bigInteger('cbt_id')->index('cbt_id');
			$table->string('thought');
			$table->integer('is_disputed');
			$table->string('dispute', 2000);
			$table->string('balanced_thoughts');
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
		Schema::drop('cbt_thoughts');
	}

}
