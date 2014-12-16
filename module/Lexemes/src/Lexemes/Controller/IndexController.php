<?php

namespace Lexemes\Controller;

use Lexemes\Form\MeaningForm;
use Lexemes\Mapper\MeaningMapper;
use Lexemes\Model\Lexeme;
use Lexemes\Model\Meaning;
use Lexemes\Service\MeaningService;
use Zend\Mvc\Controller\AbstractActionController;

class IndexController extends AbstractActionController {

	public function indexAction() {
		$meaningService = new MeaningService();
	}
	
	public function addunitAction() {
		$form = new MeaningForm();
		$request = $this->getRequest();
		if($request->isPost()) {
			$values = $request->getPost();
			
			$targetLexeme = new Lexeme('de', $values->target_type, $values->target_entry);
			
			$baseLexeme = new Lexeme('en', $values->base_type, $values->base_entry);
			
			$mapper = new MeaningMapper();
			$mapper->insertLexeme($targetLexeme);
			$mapper->insertLexeme($baseLexeme);
			
			$meaning = new Meaning($targetLexeme, $baseLexeme);
			$mapper->insertMeaning($meaning);
			
			$form->setData(array(
				'target_type' => $values->target_type,
				'target_entry' => $values->target_entry,
				
				'base_type' => $values->base_type,
			));
		}
		return array('form' => $form);
	}

}
