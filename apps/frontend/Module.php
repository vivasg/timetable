<?php

namespace Frontend;

use \Phalcon\Loader,
	\Phalcon\Mvc\View as MvcView;

defined('APP_DIR') || define('APP_DIR', APPS_DIR . 'frontend' . DIRECTORY_SEPARATOR);

class Module
{
	public function registerAutoloaders()
	{
		$loader = new Loader();

		$loader->registerNamespaces([
			'Frontend\Controllers' => APP_DIR . 'controllers' . DIRECTORY_SEPARATOR,
		]);

		$loader->register();
	}

	/**
	 * Register the services here to make them general or register in the ModuleDefinition to make them module-specific
	 *
	 * @param \Phalcon\Di $di
	 */
	public function registerServices($di)
	{
		// Registering a namespace
		$di->get('dispatcher')->setDefaultNamespace('Frontend\Controllers\\');

		// Registering the view component
		$di->setShared('view', function () {
			$view = new MvcView();
			$view->setViewsDir(APP_DIR . 'views' . DIRECTORY_SEPARATOR);
			return $view;
		});
	}
}
