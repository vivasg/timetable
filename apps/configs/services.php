<?php

use \Phalcon\Loader;

/** @var \Phalcon\Di $di */
global $di;

$loader = new Loader();

// Регистрируем папки с PSR-4
$loader->registerDirs([
	APPS_DIR . 'models',
]);

$loader->register();

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