<?php

namespace Lexemes\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

class MeaningController extends AbstractRestfulController {	
	public function getList() {
		$meaningService = $this->serviceLocator->get('meaningService');
		$meanings = $meaningService->findAllMeanings('de', 'en'); //CHANGE WITH USER FNALITY
		
		return new JsonModel($meanings);
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
