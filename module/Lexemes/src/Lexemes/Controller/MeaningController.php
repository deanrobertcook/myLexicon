<?php

namespace Lexemes\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

class MeaningController extends AbstractRestfulController {	
	public function getList() {
		$meaningService = $this->serviceLocator->get('meaningService');
		$meanings = $meaningService->findAllMeanings();
		
		$output = array();
		foreach ($meanings as $meaning) {
			$outputEntry = array (
				'id' => $meaning->getId(),
				'frequency' => $meaning->getFrequency(),
				'targetLexeme' => $this->lexemeToArray($meaning->getTargetLexeme()),
				'baseLexeme' => $this->lexemeToArray($meaning->getBaseLexeme()),
			);
			$output[] = $outputEntry;
		}
		
		return new JsonModel($output);
	}
	
	private function lexemeToArray($lexeme) {
		$output = array(
			"id" => $lexeme->getId(),
			"language" => $lexeme->getLanguage(),
			"type" => $lexeme->getType(),
			"entry" => $lexeme->getEntry(),
		);
		return $output;
	}
	
	public function get($id) {
		$lexemeService = $this->serviceLocator->get('lexemeService');
		$lexeme = $lexemeService->retrieveLexemeByID($id);
		
		$output = array(
			'targetLexeme' => array(
				'id' => $lexeme->getId(),
				'language' => $lexeme->getLanguage(),
				'type' => $lexeme->getType(),
				'entry' => $lexeme->getEntry(),
			)
		);
		
		$meaningService = $this->serviceLocator->get('meaningService');
		$meanings = $meaningService->findMeaningsForLexeme($id);
		
		$meaningCount = 1;
		foreach($meanings as $meaning) {
			$baseLexeme = $meaning->getBaseLexeme();
			$output["meaning" . $meaningCount] = array(
				'id' => $baseLexeme->getId(),
				'language' => $baseLexeme->getLanguage(),
				'type' => $baseLexeme->getType(),
				'entry' => $baseLexeme->getEntry(),
			);
			$meaningCount++;
		}
		
		
		return new JsonModel($output);
	}
}
