<?php

class UserTableSeeder extends Seeder {

	public function run()
	{
		$user = new User;
		$user->name = 'admin';
		$user->email = 'admin@change.me';
		$user->password = 'admin123';
		$user->password_confirmation = $user->password;
		
		if(!$user->save()) {
			print_r($user->errors()->all());
			return;
		}
		
		print 'Success' . PHP_EOL;
	}

}