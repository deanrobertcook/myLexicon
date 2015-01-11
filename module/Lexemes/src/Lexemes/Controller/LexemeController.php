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

	public function getList()
	{
		$lexemeService = $this->serviceLocator->get("lexemeService");
		$lexemes = $lexemeService->getAllLexemes('de', 'en');

		return new JsonModel($lexemes);
	}

	public function get($id)
	{
		$lexemeService = $this->serviceLocator->get("lexemeService");
		$lexeme = $lexemeService->getLexeme($id);

		return new JsonModel($lexeme);
	}
	
	public function create($data)
	{
		$lexemeService = $this->serviceLocator->get("lexemeService");
		$id = $lexemeService->saveLexeme($data);

		return new JsonModel(array("id" => $id));
	}

}
