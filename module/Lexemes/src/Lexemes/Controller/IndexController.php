<?php

namespace Lexemes\Controller;

use Zend\Mvc\Controller\AbstractActionController;


class IndexController extends AbstractActionController {

	public function indexAction() {
		$meaningService = $this->serviceLocator->get('meaningService');
		$lexemeService = $this->serviceLocator->get('lexemeService');
		
		$meanings = json_encode($meaningService->getAllMeanings('de', 'en'));
		$lexemes = json_encode($lexemeService->getAllLexemes('de', 'en'));
		
		return array(
			'meanings' => $meanings,
			'lexemes' => $lexemes
		);
	}
}
