<?php

class DomainObject {
	protected $id;
	
	public function __construct($id = null) {
		if ($id) {
			$this->id = $id;
		}
	}
	
	public function getID() {
		return $this->id;
	}
	
	public function setID($id) {
		$this->id = $id;
	}
	
	
}