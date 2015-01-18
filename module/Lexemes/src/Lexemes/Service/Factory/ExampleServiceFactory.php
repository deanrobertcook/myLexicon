<?php

namespace Lexemes\Service\Factory;

use Lexemes\Model\ExampleMapper;
use Lexemes\Service\Invokable\ExampleService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Description of ExampleServiceFactory
 *
 * @author dean
 */
class ExampleServiceFactory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		$PDO = $serviceLocator->get('PDO');
		$exampleMapper = new ExampleMapper($PDO);
		$exampleService = new ExampleService($exampleMapper);
		return $exampleService;
	}
}
