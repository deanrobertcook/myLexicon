<?php

namespace Lexemes\Service\Invokable;

use Lexemes\Model\Entity\Lexeme;
use Lexemes\Model\LexemeMapper;


class LexemeService {
	
	private $lexemeMapper;
	
	public function __construct($PDO) {
		$this->lexemeMapper = new LexemeMapper($PDO); 
	}
	
	public function saveLexeme(Lexeme $lexeme) {
		$this->lexemeMapper->insert($lexeme);
		return $lexeme->getID();
	}
	
	public function getLexeme($id) {
		return $this->lexemeMapper->getLexemeById($id);
	}
	
	public function getAllLexemes() {
		return $this->lexemeMapper->getAllLexemes();
	}
}