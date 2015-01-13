<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToCbtSymptomsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('cbt_symptoms', function(Blueprint $table)
		{
			$table->foreign('symptom_id', 'fk_cbt_symptoms_symptom_id')->references('id')->on('symptoms')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('cbt_id', 'fk_cbt_symptoms_cbt_id')->references('id')->on('cbts')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('cbt_symptoms', function(Blueprint $table)
		{
			$table->dropForeign('fk_cbt_symptoms_symptom_id');
			$table->dropForeign('fk_cbt_symptoms_cbt_id');
		});
	}

}
