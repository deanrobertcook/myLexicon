<?php

namespace LexemesTest\Controller;

use Exception;
use LexemesTest\Bootstrap;
use Zend\Http\Client;

abstract class AbstractRestControllerTestCase extends \PHPUnit_Extensions_Database_TestCase
{

	// only instantiate pdo once for test clean-up/fixture load
	static private $pdo = null;
	// only instantiate PHPUnit_Extensions_Database_DB_IDatabaseConnection once per test
	private $conn = null;
	private $testDbName = 'myLexiconTest';

	final public function getConnection()
	{
		if ($this->conn === null) {
			if (self::$pdo == null) {
				$PDO = $this->getTestPDO();
				self::$pdo = $PDO;
			}
			$this->conn = $this->createDefaultDBConnection(self::$pdo, $this->testDbName);
		}

		return $this->conn;
	}

	private function getTestPDO()
	{
		$serviceManager = Bootstrap::getServiceManager();
		$adapter = $serviceManager->get('dbAdapter');
		//DBUnit test cases need raw PDO object
		$PDO = $adapter->getDriver()->getConnection()->getResource();
		
		$databaseName = $PDO->query('select database()')->fetchColumn();
		if ($databaseName != "myLexiconTest") {
			throw new Exception(
			"Ensure that the PDO is set to use the an empty test database called myLexiconTest"
			);
		}
		return $PDO;
	}

	public function getDataSet()
	{
		return $this->createMySQLXMLDataSet(__DIR__ . "/resources/OriginalLexicon.xml");
	}

	private function getURI($resource)
	{
		$serviceManager = Bootstrap::getServiceManager();
		$domain = $serviceManager->get('config')["url"];
		$uri = $domain . "/" . $resource;
		return $uri;
	}

	protected function addResourceTest($resourceName, $postData)
	{
		$client = $this->getClient($resourceName, "POST");
		$client->setParameterPost($postData);
		$client->send();

		$queryTable = $this->getConnection()->createQueryTable(
			$resourceName, "SELECT * FROM " . $resourceName . " ORDER BY id"
		);
		$expectedTable = $this
			->createMySQLXMLDataSet(__DIR__ . "/resources/test" . ucfirst($resourceName) . "Add.xml")
			->getTable($resourceName);

		$this->assertTablesEqual($expectedTable, $queryTable);
	}
	
	protected function getResourceTest($resourceName) {
		$client = $this->getClient($resourceName . "/1", "GET");
		$client->send();
		$actualResponse = $client->getResponse()->getBody();
		
		$expectedRow = $this
			->createMySQLXMLDataSet(__DIR__ . "/resources/test" . ucfirst($resourceName) . "Get.xml")
			->getTable($resourceName)
			->getRow(0);
		$expectedResponse = json_encode($expectedRow);
		$this->assertEquals($expectedResponse, $actualResponse);
	}
	
	protected function getAllTest($resourceName) {
		$client = $this->getClient($resourceName, "GET");
		$client->send();
		$actualData = $client->getResponse()->getBody();
		$actualData = $this->prepareJSONResponse($actualData);
		$actualData = $this->sortArraysById($actualData);
		
		$expectedTable = $this
			->createMySQLXMLDataSet(__DIR__ . "/resources/test" . ucfirst($resourceName) . "GetAll.xml")
			->getTable($resourceName);
		$expectedData = $this->extractDataFromTableResult($expectedTable);
		$expectedData = $this->sortArraysById($expectedData);
	
		$this->assertEquals($expectedData, $actualData);
	}

	protected function getClient($resource, $method, $data = array())
	{
		$uri = $this->getURI($resource);
		$client = new Client($uri);
		$client->setAdapter('Zend\Http\Client\Adapter\Curl');
		$client->setMethod($method);
		return $client;
	}

	protected function extractDataFromTableResult($tableResult)
	{
		$arrayData = array();
		$rows = $tableResult->getRowCount();
		for ($i = 0; $i < $rows; $i++) {
			$arrayData[] = $tableResult->getRow($i);
		}
		return $arrayData;
	}

	protected function prepareJSONResponse($jsonData)
	{
		$jsonData = json_decode($jsonData);
		$preparedData = array();
		foreach ($jsonData as $object) {
			$preparedData[] = (array) $object;
		}
		return $preparedData;
	}

	protected function sortArraysById($dataSet)
	{
		$ids = array();
		foreach ($dataSet as $key => $row) {
			$ids[$key] = $row['id'];
		}
		array_multisort($ids, SORT_DESC, $dataSet);
		return $dataSet;
	}

}
