<?php

namespace Lexemes\Service\Factory;

use Lexemes\Service\Invokable\LexemeService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Description of MeaningServiceFactory
 *
 * @author dean
 */
class LexemeServiceFactory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		$adapter = $serviceLocator->get('Zend\Db\Adapter\Adapter');
		$lexemeService = new LexemeService($PDO);
		return $lexemeService;
	}
}
