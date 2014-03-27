<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'RMS: Representative Management System',

	// preloading 'log' component
	'preload'=>array('log'),

	// application components
	'components'=>array(
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=medicalv_represetative',
			'emulatePrepare' => true,
			'username' => 'medicalv',
			'password' => 'FwaD3peV',
			'charset' => 'utf8',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
			),
		),
	),
	'commandMap'=> array(
    'migrate'=> array(
      'class'=>'system.cli.commands.MigrateCommand',
      'interactive'=> false,
    ),
	),
);