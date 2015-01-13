<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToCbtsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('cbts', function(Blueprint $table)
		{
			$table->foreign('user_id', 'fk_cbts_user_id')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('tag_id', 'fk_cbts_tag_id')->references('id')->on('tags')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('cbts', function(Blueprint $table)
		{
			$table->dropForeign('fk_cbts_user_id');
			$table->dropForeign('fk_cbts_tag_id');
		});
	}

}
