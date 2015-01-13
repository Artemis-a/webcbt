<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToCbtBehavioursTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('cbt_behaviours', function(Blueprint $table)
		{
			$table->foreign('cbt_id', 'fk_cbt_behaviours_cbt_id')->references('id')->on('cbts')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('cbt_behaviours', function(Blueprint $table)
		{
			$table->dropForeign('fk_cbt_behaviours_cbt_id');
		});
	}

}
