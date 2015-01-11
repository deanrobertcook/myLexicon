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
		$meaningService = $this->serviceLocator->get('meaningService');
		$meaning = $meaningService->findMeaning($id); //CHANGE WITH USER FNALITY
		
		
		return new JsonModel($meaning);
	}
}
