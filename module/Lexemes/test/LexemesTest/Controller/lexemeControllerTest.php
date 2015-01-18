<?php

namespace LexemesTest\Controller;

use LexemesTest\Controller\AbstractRestControllerTestCase;

/**
 * Description of lexemeControllerTest
 *
 * @author dean
 */
class lexemeControllerTest extends AbstractRestControllerTestCase
{

	public function testAddLexeme()
	{
		$postData = array(
			"id" => "6",
			"language" => "en",
			"type" => "noun",
			"entry" => "direction"
		);
		
		$client = $this->getClient("lexemes", "POST");
		$client->setParameterPost($postData);
		$client->send();

		$queryTable = $this->getConnection()->createQueryTable(
			"lexemes", "SELECT * FROM lexemes ORDER BY id"
		);
		$expectedTable = $this
			->createMySQLXMLDataSet(__DIR__ . "/resources/testAddLexeme.xml")
			->getTable("lexemes");

		$this->assertTablesEqual($expectedTable, $queryTable);
	}
	
	public function testGetLexeme() {
		$client = $this->getClient("lexemes/1", "GET");
		$client->send();
		$actualResponse = $client->getResponse()->getBody();
		
		$expectedRow = $this
			->createMySQLXMLDataSet(__DIR__ . "/resources/testGetLexeme.xml")
			->getTable("lexemes")
			->getRow(0);
		$expectedResponse = json_encode($expectedRow);
		$this->assertEquals($expectedResponse, $actualResponse);
	}
	
	public function testGetAllLexemes() {
		$client = $this->getClient("lexemes", "GET");
		$client->send();
		$actualData = $client->getResponse()->getBody();
		
		$expectedTable = $this
			->createMySQLXMLDataSet(__DIR__ . "/resources/testGetAllLexemes.xml")
			->getTable("lexemes");
		
		$expectedResponse = array();
		$rows = $expectedTable->getRowCount();
		for ($i = 0; $i < $rows; $i++) {
			$expectedResponse[] = $expectedTable->getRow($i);
		}
		
		$actualData = json_decode($actualData);
		$actualResponse = array();
		foreach ($actualData as $datum) {
			$actualResponse[] = (array)$datum;
		}
	
		$this->assertEquals($expectedResponse, $actualResponse);
	}
}
