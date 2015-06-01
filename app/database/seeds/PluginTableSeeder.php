<?php

class PluginTableSeeder extends Seeder {

	public function run()
	{
		$plugin = new Plugin;
		$plugin->name = 'TestPluginPro';
		$plugin->url = 'http://google.com/';
		$plugin->reasons = ['Lorem ipsum, yeah, it works.'];
		
		if(!$plugin->save()) {
			echo 'Unable to save plugin';
			print_r($plugin->errors()->all());
		}
	}

}