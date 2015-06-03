<?php

class PluginTableSeeder extends Seeder {

	public function run()
	{
		$plugin = new Plugin;
		$plugin->name = 'TestPluginPro';
		$plugin->url = 'http://google.com/';
		$plugin->reasons = array(
			'Lorem ipsum', 
			'foo bar baz'
		);
		
		if(!$plugin->save()) {
			print_r($plugin->errors()->all());
		}
	}

}