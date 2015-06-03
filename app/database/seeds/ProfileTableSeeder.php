<?php

class ProfileTableSeeder extends Seeder {

	public function run()
	{
		$profile = new Profile;
		$profile->report_id = 1;
		$profile->name = 'Test';
		$profile->url = 'http://google.com/';
		$profile->type = Blacklist::PROFILE_SPIGOT;
		
		if(!$profile->save()) {
			print_r($profile->errors()->all());
		}
	}

}