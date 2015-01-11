<?php
return array(
	'controllers' => array(
		'invokables' => array(
			'Lexemes\Controller\Meaning' => 'Lexemes\Controller\MeaningController',
			'Lexemes\Controller\Lexeme' => 'Lexemes\Controller\LexemeController',
			'Lexemes\Controller\Index' => 'Lexemes\Controller\IndexController',
		),
	),
	'service_manager' => array(
		'factories' => array(
			'PDO' => 'Lexemes\Service\Factory\PDOFactory',
			'meaningService' => 'Lexemes\Service\Factory\MeaningServiceFactory',
			'lexemeService' => 'Lexemes\Service\Factory\LexemeServiceFactory',
		),
		'invokables' => array()
	),
	'router' => array(
		'routes' => array(
			'home' => array(
				'type' => 'Literal',
				'options' => array(
					'route' => '/',
					'defaults' => array(
                        'controller' => 'Lexemes\Controller\Index',
						'action' => 'index'
                    ),
				),	
			),
			'lexemes' => array(
				'type' => 'Literal',
				'options' => array(
					'route' => '/lexemes',
					'defaults' => array(
                        'controller' => 'Lexemes\Controller\Lexeme',
                    ),
				),
				'may_terminate' => true,
				'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:id]',
                            'constraints' => array(
								'id' => '[0-9]+',
							),
							'defaults' => array(
                            ),
                        ),
                    ),
                ),
			),
			'meanings' => array(
				'type' => 'Literal',
				'options' => array(
					'route' => '/meanings',
					'defaults' => array(
                        'controller' => 'Lexemes\Controller\Meaning',
                    ),
				),
				'may_terminate' => true,
				'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:id]',
                            'constraints' => array(
								'id' => '[0-9]+',
							),
							'defaults' => array(
                            ),
                        ),
                    ),
                ),
			),
		),
	),
	'view_manager' => array(
		'template_path_stack' => array(
            'User' => __DIR__ . '/../view',
        ),
		'strategies' => array(
            'ViewJsonStrategy',
        ),
	),
);
