<?php

namespace Lexemes\Service\Factory;

use PDO;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Description of newPHPClass
 *
 * @author dean
 */
class PDOFactory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		$dbConfig = $serviceLocator->get('config')['db']['myLexicon'];
        $PDO = new PDO($dbConfig['dsn'], $dbConfig['username'], $dbConfig['password']);
        return $PDO;
	}
}
