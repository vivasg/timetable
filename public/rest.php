<?php

defined('BASE_DIR') || define('BASE_DIR', dirname(__FILE__));
defined('APPS_DIR') || define('APPS_DIR', dirname(BASE_DIR) . DIRECTORY_SEPARATOR . 'apps' . DIRECTORY_SEPARATOR);

use \Phalcon\Mvc\Micro as Application,
	\Phalcon\Http\Response as Response,
	\Phalcon\Di;

$di = new Di();

require_once APPS_DIR . 'configs' . DIRECTORY_SEPARATOR . 'services.php';


$app = new Application();

function make_response_data($data)
{
	global $app;
	$response = [
		'links' => [
			'self' => $app->url->path($app->request->getURI()),
		],
		'data' => $data,
		'meta' => make_response_meta(),
	];

	return $response;
}

function make_response_error($http_code, $http_status, $error_title, $error_description)
{
	global $app;
	$response = [
		'id' => $http_code,
		'links' => [
			'self' => $app->url->path($app->request->getURI()),
			'about' => $app->url->path($app->request->getURI()), // TODO: додати сторінки з описом помилок
		],
		'status' => $http_status,
		'title' => $error_title,
		'detail' => $error_description,
		'source' => 0, // TODO: подумати як зробити автоматично
		'meta' => make_response_meta(),
	];

	return $response;
}

function make_response_meta()
{
	return [
		'copyright' => 'Banda Corp.',
		'authors' => [
			'Ахмед',
			'Ібрагім',
		],
	];
}
function get_responce_data_per_many($teachers)
{
	$data = [];
	/**@var Teacher $teacher*/
	foreach($teachers as $teacher)
	{
		$data[] = [
			'type' => 'teacher',
			'id' => $teacher->getId(),
			'attributes' => [
				'name_first' => $teacher->getNameFirst(),
				'name_middle' => $teacher->getNameMiddle(),
				'name_last' => $teacher->getNameLast(),
			]];
	}
	return $data;
}

/**Get all Teachers*/
$app->get('/teachers', function()
{
	$response = new Response();
	$response->setContentType('application/vnd.api+json');

	$teachers = Teacher::find(); // TODO: метод find() в класе Teacher для возврата всех учителей

	if($teachers)
	{
		$data = get_responce_data($teachers);

		$response->setJsonContent(make_response_data($data));
		$response->setStatusCode(200, 'FINDED');
	}
	else
	{
		$response->setJsonContent(make_response_error(404, 'Not found', 'Елементів не знайдено', 'Викладачів в базі не знайдено'));
		$response->setStatusCode(404, 'NOT FOUND');
	}

	return $response;
});

/**Search Teachers by Name*/
$app->get('/teachers/search/{name}', function($name)
{
	$response = new Response();
	$response->setContentType('application/vnd.api+json');

	$teachers = Teacher::findByName($name);

	if ($teachers)
	{
		$data = get_responce_data($teachers);

		$response->setJsonContent(make_response_data($data));
		$response->setStatusCode(200, 'FINDED');
	}
	else
	{
		$response->setJsonContent(make_response_error(404, 'Not found', 'Елемент не знайдено', 'Викладача з ім\'ям ' . $name . ' не знайдено'));
		$response->setStatusCode(404, 'NOT FOUND');
	}

	return $response;
});

/**Get Teacher by id*/
$app->get('/teachers/{teacher_id}', function($teacher_id)
{
	$response = new Response();
	$response->setContentType('application/vnd.api+json');

	$teacher = Teacher::findById($teacher_id);

	if ($teacher)
	{
		$response->setJsonContent(make_response_data([
			[
				'type' => 'teacher',
				'id' => $teacher->getId(),
				'attributes' => [
					'name_first' => $teacher->getNameFirst(),
					'name_middle' => $teacher->getNameMiddle(),
					'name_last' => $teacher->getNameLast(),
				],
			]
		]));
		$response->setStatusCode(200);
	}
	else
	{
		$response->setJsonContent(make_response_error(404, 'Not found', 'Елемент не знайдено', 'Викладача з індентифікатором ' . $teacher_id . ' не знайдено'));
		$response->setStatusCode(404);
	}

	return $response;
});

$app->handle();