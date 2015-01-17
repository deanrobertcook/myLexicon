<?php

namespace LexemesTest\Controller;

use LexemesTest\AbstractDatabaseTestCase;

/**
 * Description of lexemeControllerTest
 *
 * @author dean
 */
class lexemeControllerTest extends AbstractDatabaseTestCase
{

	public function testAddLexeme()
	{
		$postData = array(
			"id" => "1",
			"language" => "de",
			"type" => "verb",
			"entry" => "sich von jmdm. verabschieden"
		);
		
		$client = $this->getClient("lexemes", "POST");
		$client->setParameterPost($postData);
		$client->send();

		$queryTable = $this->getConnection()->createQueryTable(
			"lexemes", "SELECT * FROM lexemes"
		);
		$expectedTable = $this
			->createFlatXmlDataSet(__DIR__ . "/resources/testAddLexeme.xml")
			->getTable("lexemes");

		$this->assertTablesEqual($expectedTable, $queryTable);
	}
	
	public function testGetLexeme() {
		
	}

}
