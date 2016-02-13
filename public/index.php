<?php

defined('BASE_DIR') || define('BASE_DIR', dirname(__FILE__));
defined('WWW_DIR') || define('WWW_DIR', __DIR__ . DIRECTORY_SEPARATOR);
defined('APPS_DIR') || define('APPS_DIR', dirname(BASE_DIR) . DIRECTORY_SEPARATOR . 'apps' . DIRECTORY_SEPARATOR);

use \Phalcon\Mvc\Application,
	\Phalcon\Di,
	\Phalcon\Loader;

$di = new Di();

require_once APPS_DIR . 'configs' . DIRECTORY_SEPARATOR . 'services.php';

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

$application = new Application($di);

// Добавляем модули
$application->registerModules([
	'frontend' => [
		'className' => 'Frontend\Module',
		'path' => APPS_DIR . 'frontend' . DIRECTORY_SEPARATOR . 'Module.php',
	],
]);

echo $application->handle()->getContent();
