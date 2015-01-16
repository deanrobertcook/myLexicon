<?php

namespace Lexemes\Service\Factory;

use Lexemes\Model\LexemeTable;
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
		$lexemeGateway = new LexemeTable();
		$lexemeService = new LexemeService($lexemeGateway);
		return $lexemeService;
	}
}
