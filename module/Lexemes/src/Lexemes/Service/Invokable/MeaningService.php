<?php

namespace Lexemes\Service\Invokable;

use Lexemes\Model\Entity\Meaning;
use Lexemes\Model\MeaningMapper;


class MeaningService {
	
	private $meaningMapper;
	private $lexemeService;
	
	public function __construct($PDO) {
		$this->meaningMapper = new MeaningMapper($PDO);
		$this->lexemeService = new LexemeService($PDO);
	}
	
	public function saveMeaning(Meaning $meaning) {
		$targetLexeme = $meaning->getTargetLexeme();
		$baseLexeme = $meaning->getBaseLexeme();
		
		$targetID = $this->lexemeService->saveLexeme($targetLexeme);
		$baseID = $this->lexemeService->saveLexeme($baseLexeme);
		$this->meaningMapper->insertMeaning($targetID, $baseID);
	}
	
	public function getMeaning($id) {
		$meaning = $this->meaningMapper->getMeaningById($id);
		return $meaning;
	}
	
	public function getAllMeanings($targetLanguage, $baseLanguage) {
		$meanings = $this->meaningMapper->getAllMeanings($targetLanguage, $baseLanguage);
		return $meanings;
	}
}
