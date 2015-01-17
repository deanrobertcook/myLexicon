<?php

namespace Lexemes\Controller;

use Zend\Mvc\Controller\AbstractActionController;


class IndexController extends AbstractActionController {

	public function indexAction() {
		$meaningService = $this->serviceLocator->get('meaningService');
		$lexemeService = $this->serviceLocator->get("lexemeService");
		$exampleService = $this->serviceLocator->get('exampleService');
		
		$meanings = json_encode($meaningService->readAllMeanings('de', 'en'));
		$lexemes = json_encode($lexemeService->readAllLexemes('de', 'en'));
		$examples = json_encode($exampleService->readAllExamples());
		
		return array(
			'meanings' => $meanings,
			'lexemes' => $lexemes,
			'examples' => $examples,
		);
	}
}
