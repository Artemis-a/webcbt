<?php
/**
 * The MIT License (MIT)
 *
 * WebCBT - Web based Cognitive Behavioral Therapy tool
 *
 * http://webcbt.github.io
 *
 * Copyright (c) 2014 Prashant Shah <pshah.webcbt@gmail.com>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

class SetupController extends BaseController
{

	public function getIndex()
	{
		return Redirect::action('SetupController@getInstall');
	}

	public function getInstall()
	{
		/* Check if database name is set in database config */
		if (Config::get('database.connections.mysql.database') != '')
		{
			return Redirect::intended('dashboard')
				->with('alert-danger', 'Application already installed.');
		}
	
		return View::make('setup.install');
	}

	public function postInstall()
	{
		$input = Input::all();

		if ($input['password'] != $input['confirmpassword'])
		{
			return Redirect::back()->withInput()
				->with('alert-danger', 'Administrator password\'s do not match.');

		}

		/* Check for database connection */
		try {
			$conn = new PDO("mysql:host=" . $input['dbhost'] . ";dbname=" . $input['dbname'],
				$input['dbusername'], $input['dbpassword']);
			// set the PDO error mode to exception
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch(PDOException $e) {
			return Redirect::back()->withInput()
				->with('alert-danger', 'Connection failed: ' . $e->getMessage());
		}

		/* Read the database installation script */
		$script = file_get_contents('../app/database/schema-v1.sql');
		if (!$script) {
			return Redirect::back()->withInput()
				->with('alert-danger', 'Failed to read database script file.');
		}

		/* Execute the database installation script */
		try {
			$conn->exec($script);
		} catch (PDOException $e) {
			return Redirect::back()->withInput()
				->with('alert-danger', 'Script execution failed: ' . $e->getMessage());
		}

		/* Insert admin user */
		try {
			$password = Hash::make($input['password']);

			$usersql = "INSERT INTO users(id, username, password, fullname, email, gender, dob,
				is_admin, timezone, dateformat_php, dateformat_cal, dateformat_js, admin_verified, email_verified, email_token,
				status, last_login, remember_token, reset_password_key, reset_password_date,
				created_at) VALUES
				(1, :username, :password, 'Administrator', :email, 'M', '2000-01-01',
				1, 'UTC', 'd-M-Y', 'dd-M-yy', 'dd-MM-yyyy', 1, 1, NULL,
				1, NULL, NULL, NULL, NULL,
				now());";

			$userstmt = $conn->prepare($usersql);

			$userstmt->bindParam(':username', $input['username'], PDO::PARAM_STR);
			$userstmt->bindParam(':password', $password, PDO::PARAM_STR);
			$userstmt->bindParam(':email', $input['email'], PDO::PARAM_STR);

			$userstmt->execute();
		} catch(PDOException $e) {
			return Redirect::back()->withInput()
				->with('alert-danger', 'Failed to add administrator user: ' . $e->getMessage());
		}

		/* Insert initial data */
		$database_version = 1;
		try {
			$initsql = "INSERT INTO settings(id, database_version) VALUES (1, :database_version);";

			$initstmt = $conn->prepare($initsql);

			$initstmt->bindParam(':database_version', $database_version, PDO::PARAM_STR);

			$initstmt->execute();
		} catch(PDOException $e) {
			return Redirect::back()->withInput()
				->with('alert-danger', 'Failed to add initial data: ' . $e->getMessage());
		}

		/* Close database connection */
		$conn = null;

		/* Create database configuration file */
		$config_file = <<<FILEDATA
<?php
return array(
	'fetch' => PDO::FETCH_CLASS,
	'default' => 'mysql',
	'connections' => array(
		'mysql' => array(
			'driver'    => 'mysql',
			'host'      => '{$input['dbhost']}',
			'port'      => '{$input['dbport']}',
			'database'  => '{$input['dbname']}',
			'username'  => '{$input['dbusername']}',
			'password'  => '{$input['dbpassword']}',
			'charset'   => 'utf8',
			'collation' => 'utf8_unicode_ci',
			'prefix'    => '',
		),
	),
	'migrations' => 'migrations',
);
FILEDATA;

		// Write to database config file
		$status = File::put('../app/config/database.php', $config_file);
		if ($status === false)
		{
			return Redirect::back()->withInput()
				->with('alert-danger', 'Failed to create database config file. Kindly create the app/config/database.php file manually.');
		}

		User::initDB(1);

		return Redirect::action('UsersController@getLogin')
			->with('alert-success', 'Setup completed.');
	}
}
