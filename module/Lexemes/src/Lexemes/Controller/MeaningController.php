<?php

namespace Lexemes\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

class MeaningController extends AbstractRestfulController
{

	public function getList()
	{
		$meaningService = $this->serviceLocator->get('meaningService');
		$meanings = $meaningService->getAllMeanings('de', 'en'); //CHANGE WITH USER FNALITY

		return new JsonModel($meanings);
	}

	public function get($id)
	{
		$meaningService = $this->serviceLocator->get('meaningService');
		$meaning = $meaningService->getMeaning($id); //CHANGE WITH USER FNALITY

		return new JsonModel($meaning);
	}

	public function create($data)
	{
		$meaningService = $this->serviceLocator->get('meaningService');
		$id = $meaningService->saveMeaning($data);

		return new JsonModel(array("id" => $id));
	}

}
