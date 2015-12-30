<?php

$routers = new \Phalcon\Mvc\Router();

$frontend_routers = new \Phalcon\Mvc\Router\Group(['module' => 'frontend',]);

$frontend_routers->add('/', [
	'controller' => 'index',
	'action' => 'index',
])->setName('home');

$routers->mount($frontend_routers);

$routers->notFound([
	'controller' => 'error',
	'action' => '404',
]);

return $routers;
