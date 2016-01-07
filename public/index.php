<?php

defined('BASE_DIR') || define('BASE_DIR', dirname(__FILE__));
defined('APPS_DIR') || define('APPS_DIR', dirname(BASE_DIR) . DIRECTORY_SEPARATOR . 'apps' . DIRECTORY_SEPARATOR);

use \Phalcon\Mvc\Application,
	\Phalcon\Di,
	\Phalcon\Loader;

$loader = new Loader();

// Регистрируем папки с PSR-4
$loader->registerDirs([
	APPS_DIR . 'models',
]);

$loader->register();

$di = new Di();

// Добавляем конфиг в DI
$di->setShared('config', function()
{
	return require_once APPS_DIR . 'configs' . DIRECTORY_SEPARATOR . 'config.php';
});

// Подключка в БД
$di->setShared('db', function() use ($di)
{
	$db = new \Phalcon\Db\Adapter\Pdo\Mysql($di->getShared('config')->database->toArray());
	return $db;
});

// Роутинг
$di->setShared('router', function()
{
	return require_once APPS_DIR . 'configs' . DIRECTORY_SEPARATOR . 'routers.php';
});

// Диспетчер
$di->setShared('dispatcher', function ()
{
	return new \Phalcon\Mvc\Dispatcher();
});

// Сервис для подключения css, js
$di->setShared('assets', function ()
{
	return new \Phalcon\Assets\Manager();
});

// Сервис для безопасной обработки строк
$di->setShared('escaper', function ()
{
	return new \Phalcon\Escaper();
});

// Сервис для задания из PHP HTML тегов
$di->setShared('tag', function ()
{
	return new \Phalcon\Tag();
});

// Сервис реализующий HTTP ответ
$di->setShared('response', function ()
{
	return new \Phalcon\Http\Response();
});

$di->setShared('modelsManager', function ()
{
	return new \Phalcon\Mvc\Model\Manager();
});

$di->setShared('modelsMetadata', function ()
{
	return new \Phalcon\Mvc\Model\MetaData\Memory();
});

// Для создания линков в т.ч. ЧПУ
$di->setShared('url', function() use ($di)
{
	$url = new \Phalcon\Mvc\Url();
	$url->setBaseUri('/');
	$url->setBasePath('http://timetable');
	return $url;
});

$application = new Application($di);

// Добавляем модули
$application->registerModules([
	'frontend' => [
		'className' => 'Frontend\Module',
		'path' => APPS_DIR . 'frontend' . DIRECTORY_SEPARATOR . 'Module.php',
	],
]);

echo $application->handle()->getContent();