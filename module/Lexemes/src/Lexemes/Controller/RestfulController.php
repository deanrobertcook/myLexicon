<?php

namespace Lexemes\Controller;

use Lexemes\Service\LexemeService;
use Lexemes\Service\MeaningService;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

class RestfulController extends AbstractRestfulController {
	private $meaningService;
	private $lexemeService;
	
	public function __construct() {
		$this->meaningService = new MeaningService();
		$this->lexemeService = new LexemeService();
	}
	
	public function getList() {
		$meanings = $this->meaningService->findAllMeanings();
		
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
		return new JsonModel(array('some test data' => 'some more test data'));
	}
}
