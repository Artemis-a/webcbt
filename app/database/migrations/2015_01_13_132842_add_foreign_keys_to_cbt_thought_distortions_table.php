<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToCbtThoughtDistortionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('cbt_thought_distortions', function(Blueprint $table)
		{
			$table->foreign('distortion_id', 'fk_cbt_thought_distortions_distortion_id')->references('id')->on('distortions')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('cbt_thought_id', 'fk_cbt_thought_distortions_cbt_thought_id')->references('id')->on('cbt_thoughts')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('cbt_thought_distortions', function(Blueprint $table)
		{
			$table->dropForeign('fk_cbt_thought_distortions_distortion_id');
			$table->dropForeign('fk_cbt_thought_distortions_cbt_thought_id');
		});
	}

}
