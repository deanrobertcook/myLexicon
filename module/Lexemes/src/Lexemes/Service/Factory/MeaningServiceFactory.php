<?php

namespace Lexemes\Service\Factory;

use Lexemes\Service\Invokable\MeaningService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Description of MeaningServiceFactory
 *
 * @author dean
 */
class MeaningServiceFactory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		$PDO = $serviceLocator->get('PDO');
		$meaningService = new MeaningService($PDO);
		return $meaningService;
	}
}
