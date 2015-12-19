<?php

$_config = [
	'database' => [
		'host' => 'localhost',
		'username' => 'dev',
		'password' => '1',
		'dbname' => 'timetable',
		'prefix' => '',
		'charset' => 'utf8',
	],
];


return new \Phalcon\Config($_config);
