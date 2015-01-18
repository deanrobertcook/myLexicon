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
	
	private function getTestPDO() {
		$serviceManager = Bootstrap::getServiceManager();
		$PDO = $serviceManager->get('PDO');
		$databaseName = $PDO->query('select database()')->fetchColumn();
		if ($databaseName != "myLexiconTest") {
			throw new Exception(
				"Ensure that the PDO is set to use the an empty test database called myLexiconTest"
			);
		}
		return $PDO;
	}
	
	public function getDataSet() {
		return $this->createMySQLXMLDataSet(__DIR__ . "/resources/OriginalLexicon.xml");
	}
	
	private function getURI($resource) {
		$serviceManager = Bootstrap::getServiceManager();
		$domain = $serviceManager->get('config')["url"];
		$uri = $domain . "/" . $resource;
		return $uri;
	}
	
	protected function getClient($resource, $method, $data = array()) {
		$uri = $this->getURI($resource);
		$client = new Client($uri);
		$client->setAdapter('Zend\Http\Client\Adapter\Curl');
		$client->setMethod($method);
		return $client;
	}
}