<?php

namespace LexemesTest;

abstract class AbstractDatabaseTestCase extends \PHPUnit_Extensions_Database_TestCase
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
			throw new \Exception(
				"Ensure that the PDO is set to use the an empty test database called myLexiconTest"
			);
		}
		return $PDO;
	}
	
	public function getDataSet() {
		return $this->createMySQLXMLDataSet(__DIR__ . "/EmptyLexicon.xml");
	}
}