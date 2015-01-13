<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCbtThoughtDistortionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cbt_thought_distortions', function(Blueprint $table)
		{
			$table->bigInteger('id', true);
			$table->bigInteger('cbt_thought_id')->index('cbt_thought_id');
			$table->bigInteger('distortion_id')->index('distortion_id');
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
		Schema::drop('cbt_thought_distortions');
	}

}
