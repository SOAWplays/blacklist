<?php

use LaravelBook\Ardent\Ardent;

class Plugin extends Ardent {
    
    public static $rules = array(
		'url'		=> 'required|url',
		'name'		=> 'required|string|between:3,32'
	);
    
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'plugins';
	
	public function getReasonsAttribute() {
		return json_decode($this->attributes['reasons']);
	}
	
	public function setReasonsAttribute(Array $val) {
		$this->attributes['reasons'] = json_encode($val);
	}
}