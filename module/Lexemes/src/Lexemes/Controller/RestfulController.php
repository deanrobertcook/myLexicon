<?php

namespace Lexemes\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

class RestfulController extends AbstractRestfulController {	
	public function getList() {
		$meaningService = $this->serviceLocator->get('meaningService');
		$meanings = $meaningService->findAllMeanings();
		
		$output = array();
		foreach ($meanings as $meaning) {
			$outputEntry = array (
				'frequency' => $meaning->getFrequency(),
				'targetid' => $meaning->getTargetLexeme()->getID(),
				'targetLanguage' => $meaning->getTargetLexeme()->getLanguage(),
				'targetType' => $meaning->getTargetLexeme()->getType(),
				'targetEntry' => $meaning->getTargetLexeme()->getEntry(),
				'baseid' => $meaning->getBaseLexeme()->getID(),
				'baseLanguage' => $meaning->getBaseLexeme()->getLanguage(),
				'baseType' => $meaning->getBaseLexeme()->getType(),
				'baseEntry' => $meaning->getBaseLexeme()->getEntry(),
			);
			$output[] = $outputEntry;
		}
		
		return new JsonModel($output);
	}
	
	public function get($id) {
		$lexemeService = $this->serviceLocator->get('lexemeService');
		$lexeme = $lexemeService->retrieveLexemeByID($id);
		
		$output = array(
			'id' => $lexeme->getId(),
			'language' => $lexeme->getLanguage(),
			'type' => $lexeme->getType(),
			'entry' => $lexeme->getEntry(),
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
