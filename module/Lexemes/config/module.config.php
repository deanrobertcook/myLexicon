<?php
return array(
	'controllers' => array(
		'invokables' => array(
			'Lexemes\Controller\Restful' => 'Lexemes\Controller\RestfulController',
		),
	),
	'router' => array(
		'routes' => array(
			'lexemes' => array(
				'type' => 'Literal',
				'options' => array(
					'route' => '/myLexicon',
					'defaults' => array(
                        'controller' => 'Lexemes\Controller\Restful',
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
		'strategies' => array(
            'ViewJsonStrategy',
        ),
	),
);
