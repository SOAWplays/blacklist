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
	
	public function getIdAttribute() {
		return intval($this->attributes['id']);
	}
	
	public function setIdAttribute($val) {
		if(is_int($val)) {
			$this->attributes['id']	= $val;
		} else {
			$this->attributes['id'] = intval($val);
		}
	}
	
	public function getReasonsAttribute() {
		return json_decode($this->attributes['reasons']);
	}
	
	public function setReasonsAttribute(Array $val) {
		$this->attributes['reasons'] = json_encode($val);
	}
	
	public function getActiveAttribute() {
		return $this->attributes['active'] == 1;
	}
	
	public function setActiveAttribute($val) {
		if($val == true) {
			$this->attributes['active'] = 1;
		} else { 
			$this->attributes['active'] = 0;
		}
	}
}