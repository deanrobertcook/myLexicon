<?php

namespace LexemesTest\Controller;

use LexemesTest\AbstractDatabaseTestCase;
use LexemesTest\Bootstrap;
use Zend\Http\Client;

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
		
		$serviceManager = Bootstrap::getServiceManager();
		$domain = $serviceManager->get('config')["url"];
		$uri = $domain . "/lexemes";
		
		$client = new Client($uri);
		$client->setAdapter('Zend\Http\Client\Adapter\Curl');
		$client->setMethod("POST");
		$client->setParameterPOST($postData);
		$client->send();
		
		$queryTable = $this->getConnection()->createQueryTable(
			"lexemes", "SELECT * FROM lexemes"
		);
		$expectedTable = $this->createFlatXmlDataSet(__DIR__ . "/resources/testAddLexeme.xml")
                              ->getTable("lexemes");
		
		$this->assertTablesEqual($expectedTable, $queryTable);
	}
}
