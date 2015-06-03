<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();
		
		print 'Working from: ' . __DIR__ . PHP_EOL;
		
		$files = scandir(__DIR__);
		foreach($files as $file) {
			$fileName = basename($file, '.' . pathinfo($file)['extension']);
			if($fileName == 'DatabaseSeeder') continue;
			if($this->endsWith($file, '.php')) {
				$this->call($fileName);
			}		
		}
	}
	
	private function endsWith($haystack, $needle) {
    	return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== FALSE);
	}

}
