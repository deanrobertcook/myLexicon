<?php

namespace LexemesTest\Controller;

use LexemesTest\Controller\AbstractRestControllerTestCase;

/**
 * Description of lexemeControllerTest
 *
 * @author dean
 */
class LexemeControllerTest extends AbstractRestControllerTestCase
{

	private $resourceName = "lexemes";
	
	public function testAddLexeme()
	{
		$postData = array(
			"language" => "en",
			"type" => "noun",
			"entry" => "direction"
		);
		
		$this->addResourceTest($this->resourceName, $postData);
	}
	
	public function testGetLexeme() {
		$this->getResourceTest($this->resourceName);
	}
	
	public function testGetAllLexemes() {
		$this->getAllTest($this->resourceName);
	}
}
