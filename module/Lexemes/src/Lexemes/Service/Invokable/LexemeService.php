<?php

namespace Lexemes\Service\Invokable;

use Lexemes\Model\Entity\Lexeme;
use Lexemes\Model\LexemeMapper;


class LexemeService {
	
	private $lexemeMapper;
	
	public function __construct($PDO) {
		$this->lexemeMapper = new LexemeMapper($PDO); 
	}
	
	public function saveLexeme($lexemeData) {
		$lexemeId = $this->lexemeMapper->saveLexeme($lexemeData);
		return $lexemeId;
	}
	
	public function getLexeme($id) {
		return $this->lexemeMapper->getLexemeById($id);
	}
	
	public function getAllLexemes($targetLanguage, $baseLanguage) {
		return $this->lexemeMapper->getAllLexemes($targetLanguage, $baseLanguage);
	}
}