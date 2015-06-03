<?php

use LaravelBook\Ardent\Ardent;

class Profile extends Eloquent {
	protected $appends = array('type_friendly');
	protected $guarded = array('id');
	
	public function getIdAttribute() {
	    return intval($this->attributes['id']);
	}
	
	public function getReportIdAttribute() {
	    return intval($this->attributes['report_id']);
	}
	
	public function getReasonsAttribute() {
		return json_decode($this->attributes['reasons']);
	}
	
	public function getTypeAttribute() {
	    return $this->attributes['type'];
	}
	
	public function setReasonsAttribute(Array $val) {
		$this->attributes['reasons'] = json_encode($val);
	}
	
	public function getTypeFriendlyAttribute() {
	    return Blacklist::alias($this->attributes['type']);
	}
}