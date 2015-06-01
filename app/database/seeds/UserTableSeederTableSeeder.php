<?php

class UserTableSeederTableSeeder extends Seeder {

	public function run()
	{
		$user = new User;
		$user->username = 'admin';
		$user->email = 'admin@change.me';
		$user->password = Hash::make('admin123');
		$user->password_confirmation = $user->password;
		
		if($user->save()) {
			echo 'Successful';
		}
	}

}