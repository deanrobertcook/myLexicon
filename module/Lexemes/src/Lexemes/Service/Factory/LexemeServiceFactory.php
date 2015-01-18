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
		$adapter = $serviceLocator->get('dbAdapter');
		$lexemeMapper = new LexemeMapper($adapter);
		$lexemeService = new LexemeService($lexemeMapper);
		return $lexemeService;
	}

}
