<?php
namespace Lexemes\Model;

class Lexeme extends DomainObject implements LexemeInterface {
	private		$language,
				$type,
				$entry;
	
	public function getLanguage() {
		return $this->language;
	}
	
	public function getType() {
		return $this->type;
	}
	
	public function getEntry() {
		return $this->entry;
	}
	
	public function setLanguage($language) {
		$this->language = $language;
	}
	
	public function setType($type) {
		$this->type = $type;
	}
	
	public function setEntry($entry) {
		$this->entry = $entry;
	}
}