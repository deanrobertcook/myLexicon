<?php

namespace Lexemes\Service\Invokable;

class LexemeService
{

	private $lexemeTable;

	public function __construct($lexemeTable)
	{
		$this->lexemeTable = $lexemeTable;
	}
	
	public function createLexeme($lexemeData) {
		$lexemeId = $this->lexemeMapper->createLexeme($lexemeData);
		return $lexemeId;
	}
	
	public function readLexeme($id) {
		return $this->lexemeMapper->readLexeme($id);
	}
	
	public function readAllLexemes($targetLanguage, $baseLanguage) {
		return $this->lexemeMapper->readAllLexemes($targetLanguage, $baseLanguage);
	}

}
