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
 * Description of RestfulExampleController
 *
 * @author dean
 */
class ExampleController extends AbstractRestfulController
{

	public function getList()
	{
		$exampleService = $this->serviceLocator->get("exampleService");
		$examples = $exampleService->readAllExamples();

		return new JsonModel($examples);
	}

	public function get($id)
	{
		$exampleService = $this->serviceLocator->get("exampleService");
		$example = $exampleService->readExample($id);

		return new JsonModel($example);
	}

	public function create($data)
	{
		$exampleService = $this->serviceLocator->get("exampleService");
		$id = $exampleService->createExample($data);

		return new JsonModel(array("id" => $id));
	}

	public function update($id, $data)
	{
		$exampleService = $this->serviceLocator->get("exampleService");
		$exampleService->updateExample($id, $data);

		return new JsonModel(array("id" => $id));
	}

}
