<?php

namespace Lexemes\Model\Entity;

class Meaning {
	private $targetLexeme;
	private $baseLexeme;
	private $frequency;
	
	public function __construct(Lexeme $targetLexeme, Lexeme $baseLexeme) {
		$this->targetLexeme = $targetLexeme;
		$this->baseLexeme = $baseLexeme;
	}
	
	public function setFrequency($frequency) {
		$this->frequency = $frequency;
		return $this;
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