<?php

namespace LexemesTest\Controller;

use LexemesTest\Controller\AbstractRestControllerTestCase;

/**
 * Description of lexemeControllerTest
 *
 * @author dean
 */
class MeaningControllerTest extends AbstractRestControllerTestCase
{

	private $resourceName = "meanings";
	
	public function testAddMeaning()
	{
		$postData = array(
			"id" => "3",
			//This should be determined by back end, not through API?
			//"userid" => "1"
			"targetId" => "4",
			"baseId" => "5",
			"frequency" => "1",
			"dateEntered" => "0000-00-00 00:00:00"
		);
		
		$this->addResourceTest("meanings", $postData);
	}
	
	public function testGetMeaning() {
		$this->getResourceTest($this->resourceName);
	}
	
	public function testGetAllMeanings() {
		$this->getAllTest($this->resourceName);
	}
}
