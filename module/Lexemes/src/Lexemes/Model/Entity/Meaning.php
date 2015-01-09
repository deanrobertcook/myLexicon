<?php

namespace Lexemes\Model\Entity;

class Meaning {
	private $id;
	private $targetLexeme;
	private $baseLexeme;
	private $frequency;
	
	public function __construct(Lexeme $targetLexeme, Lexeme $baseLexeme) {
		$this->targetLexeme = $targetLexeme;
		$this->baseLexeme = $baseLexeme;
	}
	
	public function setId($id) {
		$this->id = $id;
	}
	
	public function setFrequency($frequency) {
		$this->frequency = $frequency;
		return $this;
	}
	
	public function getId() {
		return $this->id;
	}
	
	public function getFrequency() {
		return $this->frequency;
	}
	
	public function getTargetLexeme() {
		return $this->targetLexeme;
	}
	
	public function getBaseLexeme() {
		return $this->baseLexeme;
	}
}