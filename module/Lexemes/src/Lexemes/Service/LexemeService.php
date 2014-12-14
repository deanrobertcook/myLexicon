<?php

namespace Lexemes\Service;

use Lexemes\Mapper\LexemeMapper;
use Lexemes\Model\Lexeme;

class LexemeService {
	
	private $lexemeMapper;
	
	public function __construct() {
		$this->lexemeMapper = new LexemeMapper(); 
	}
	
	public function saveLexeme(Lexeme $lexeme) {
		$this->lexemeMapper->insert($lexeme);
		return $lexeme->getID();
	}
	
	public function retrieveLexemeByID($id) {
		return $this->lexemeMapper->findWithID($id);
	}
}