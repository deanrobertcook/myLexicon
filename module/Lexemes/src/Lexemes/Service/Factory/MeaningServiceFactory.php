<?php

namespace Lexemes\Service\Factory;

use Lexemes\Model\MeaningMapper;
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
		
		$auth = $serviceLocator->get('zfcuser_auth_service');
		if ($auth->hasIdentity()) {
			$adapter = $serviceLocator->get('dbAdapter');
			$meaningMapper = new MeaningMapper($adapter);
			$meaningService = new MeaningService($meaningMapper, $auth->getIdentity()->getId());
			return $meaningService;
		}
	}

}
