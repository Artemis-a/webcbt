<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToCbtFeelingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('cbt_feelings', function(Blueprint $table)
		{
			$table->foreign('feeling_id', 'fk_cbt_feelings_feeling_id')->references('id')->on('feelings')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('cbt_id', 'fk_cbt_feelings_cbt_id')->references('id')->on('cbts')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('cbt_feelings', function(Blueprint $table)
		{
			$table->dropForeign('fk_cbt_feelings_feeling_id');
			$table->dropForeign('fk_cbt_feelings_cbt_id');
		});
	}

}
