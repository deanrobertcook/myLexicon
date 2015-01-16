<?php

namespace Lexemes\Service\Invokable;

use Lexemes\Model\LexemeMapper;

class LexemeService
{
	private $lexemeMapper;
	
	public function __construct($PDO)
	{
		$this->lexemeMapper = new LexemeMapper($PDO);
	}

	public function createLexeme($lexemeData)
	{
		$lexemeId = $this->lexemeMapper->createLexeme($lexemeData);
		return $lexemeId;
	}

	public function readLexeme($id)
	{
		return $this->lexemeMapper->readLexeme($id);
	}

	public function readAllLexemes($targetLanguage, $baseLanguage)
	{
		return $this->lexemeMapper->readAllLexemes($targetLanguage, $baseLanguage);
	}

	public function updateLexeme($id, $lexemeData)
	{
		$this->lexemeMapper->updateLexeme($id, $lexemeData);
	}

}
