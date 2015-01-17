<?php

namespace LexemesTest;

use PDO;

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
		$dbConfig = $serviceManager->get('config')['db'][$this->testDbName];
        $PDO = new PDO($dbConfig['dsn'], $dbConfig['username'], $dbConfig['password']);
		return $PDO;
	}
}