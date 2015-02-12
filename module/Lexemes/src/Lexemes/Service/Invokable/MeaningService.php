<?php

namespace Lexemes\Service\Invokable;

use Lexemes\Model\MeaningMapper;


class MeaningService {
	
	private $meaningMapper;
	private $userId;
	
	public function __construct(MeaningMapper $meaningMapper, $userId) {
		$this->meaningMapper = $meaningMapper;
		$this->userId = $userId;
	}
	
	public function createMeaning($meaningData) {
		$meaningId = $this->meaningMapper->createMeaning($meaningData, $this->userId);
		return $meaningId;
	}
	
	public function readMeaning($id) {
		$meaning = $this->meaningMapper->readMeaning($id);
		return $meaning;
	}
	
	public function readAllMeanings($targetLanguage, $baseLanguage) {
		$meanings = $this->meaningMapper->readAllMeanings($targetLanguage, $baseLanguage, $this->userId);
		return $meanings;
	}
	
	public function updateMeaning($id, $meaningData) {
		
	}
}
