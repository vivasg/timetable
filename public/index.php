<?php

defined('BASE_DIR') || define('BASE_DIR', dirname(__FILE__))
defined('APPS_DIR') || define('APPS_DIR', dirname(BASE_DIR) . DIRECTORY_SEPARATOR . 'apps' . DIRECTORY_SEPARATOR);

use \Phalcon\Mvc\Application,
	\Phalcon\Di,
	\Phalcon\Loader;

$loader = new Loader();

// Регистрируем папки с PSR-4
$loader->register([
	APPS_DIR . 'models',
]);

$di = new Di();

// Добавляем конфиг в DI
$di->setShared('config', function()
{
	return require_once APPS_DIR . 'configs' . DIRECTORY_SEPARATOR . 'config.php';
});

// Подключка в БД
$di->setShared('db', function() use ($di)
{
	$db = new \Phalcon\Db\Adapter\Pdo\Mysql($di->config->database);
	return $db;
});

// Роутинг
$di->setShared('router', function()
{
	return require_once APPS_DIR . 'configs' . DIRECTORY_SEPARATOR . 'routers.php';
});

// Добавляем модули
$application->registerModules([
	'frontend' => [
		'className' => 'Frontend\Module',
		'path' => APPS_DIR . 'frontend' . DIRECTORY_SEPARATOR . 'Module.php',
	],
]);

$application = new Application($di);
