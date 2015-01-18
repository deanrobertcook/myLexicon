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
		$adapter = $serviceLocator->get('dbAdapter');
		$exampleMapper = new ExampleMapper($adapter);
		$exampleService = new ExampleService($exampleMapper);
		return $exampleService;
	}
}
