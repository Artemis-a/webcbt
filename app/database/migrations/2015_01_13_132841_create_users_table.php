<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->bigInteger('id', true);
			$table->string('username');
			$table->string('password');
			$table->string('fullname');
			$table->string('email');
			$table->char('gender', 1);
			$table->date('dob');
			$table->string('dateformat');
			$table->string('timezone');
			$table->dateTime('last_login');
			$table->string('options');
			$table->integer('status');
			$table->string('verification_key');
			$table->integer('email_verified');
			$table->integer('admin_verified');
			$table->integer('retry_count');
			$table->string('reset_password_key')->nullable();
			$table->dateTime('reset_password_date')->nullable();
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
		Schema::drop('users');
	}

}
