<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class UpdatePluginsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('plugins', function(Blueprint $table)
		{
			/*
			 * Represent whether a plugin is active or has been deleted
			 */
			$table->boolean('active')->default(true);
			
			/*
			 * Little explanation of why the plugin is on the blacklist
			 */
			$table->string('reasons')->default('[]');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('plugins', function(Blueprint $table)
		{
			$table->dropColumn(array('active', 'reasons'));
		});
	}

}
