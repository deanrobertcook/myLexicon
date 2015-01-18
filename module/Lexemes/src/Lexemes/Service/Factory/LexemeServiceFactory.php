<?php

namespace Lexemes\Service\Factory;

use Lexemes\Model\LexemeMapper;
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
		$PDO = $serviceLocator->get('PDO');
		$lexemeMapper = new LexemeMapper($PDO);
		$lexemeService = new LexemeService($lexemeMapper);
		return $lexemeService;
	}

}
