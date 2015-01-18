<?php

namespace Lexemes\Service\Invokable;

use Lexemes\Model\ExampleMapper;

class ExampleService
{
	private $exampleMapper;
	
	public function __construct(ExampleMapper $exampleMapper)
	{
		$this->exampleMapper = $exampleMapper;
	}

	public function createExample($exampleData)
	{
		$exampleId = $this->exampleMapper->createExample($exampleData);
		return $exampleId;
	}

	public function readExample($id)
	{
		return $this->exampleMapper->readExample($id);
	}

	public function readAllExamples()
	{
		return $this->exampleMapper->readAllExamples();
	}

	public function updateExample($id, $exampleData)
	{
		$this->exampleMapper->updateExample($id, $exampleData);
	}

}
