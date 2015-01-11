<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Lexemes\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

/**
 * Description of RestfulLexemeController
 *
 * @author dean
 */
class LexemeController extends AbstractRestfulController
{
	public function getList() {
		$lexemeService = $this->serviceLocator->get("lexemeService");
		$lexemes = $lexemeService->getAllLexemes();
		$output = array();
		foreach($lexemes as $lexeme) {
			$output[] = array(
				"id" => $lexeme->getId(),
				"language" => $lexeme->getLanguage(),
				"type" => $lexeme->getType(),
				"entry" => $lexeme->getEntry(),
			);
		}
		
		return new JsonModel($output);
	}
}
