<?php

namespace LexemesTest\Controller;

use LexemesTest\Controller\AbstractRestControllerTestCase;

/**
 * Description of lexemeControllerTest
 *
 * @author dean
 */
class ExampleControllerTest extends AbstractRestControllerTestCase
{

	private $resourceName = "examples";
	
	public function testAddExample()
	{
		$postData = array(
			"meaningId" => "2",
			"exampleTarget" => "Wie wirkt Ihre Ausstrahlung auf andere?",
			"exampleBase" => "How does your charisma come across to others?"
		);
		
		$this->addResourceTest($this->resourceName, $postData);
	}
	
	public function testGetExample() {
		$this->getResourceTest($this->resourceName);
	}
	
	public function testGetAllExamples() {
		$this->getAllTest($this->resourceName);
	}
}
