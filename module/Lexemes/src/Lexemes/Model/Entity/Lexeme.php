<?php

namespace Lexemes\Model\Entity;

class Lexeme {
	private $id;
	private $language;
	private $type;
	private $entry;
	
	public function __construct($language, $type, $entry) {
		$this->language = $language;
		$this->type = $type;
		$this->entry = $entry;
	}
	
	public function setID($id) {
		$this->id = $id;
		return $this;
	}
	
	public function getID() {
		return $this->id;
	}

	public function getLanguage() {
		return $this->language;
	}
	
	public function getType() {
		return $this->type;
	}
	
	public function getEntry() {
		return $this->entry;
	}
}