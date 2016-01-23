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
		'source' => make_response_source(),
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

function make_response_source()
{
	return [
		'pointer' => 'data/attributes',
	];
}

$app->get('teacher/', function() use ($app)
{
	$teachers = Teacher::find();
	{
		$data = array();
		foreach ($teachers as $teacher) {
			$data[] = array(
					'id' => $teacher->getId(),
					'attributes' => [
							'name_firs' => $teacher->getNameFirst(),
							'name_middle' => $teacher->getNameMiddle(),
							'name_last' => $teacher->getNameLast()
					]
			);
		}
	}

	return json_encode($data);

});

$app->get('teacher/find/by/name/{names}', function($names) use ($app)
{
	$teachers = Teacher::find_by_name();
	$response = new Response();

	if($teachers)
	{
		$data = array();
		foreach ($teachers as $teacher)
		{
			$data[] = array(
					'id' => $teacher->getId(),
					'attributes' => [
							'name_firs' => $teacher->getNameFirst(),
							'name_middle' => $teacher->getNameMiddle(),
							'name_last' => $teacher->getNameLast()
					]
			);
		}
		$response->setJsonContent(make_response_data($data));
		$response->setStatusCode(200);
	}

	else
	{
		$response->setJsonContent(make_response_error(404, 'Not found', 'Елемент/Елементи не знайдено', 'Викладачів з іменем' . $names . 'не знайдено'));
		$response->setStatusCode(404);
	}

	return $response;

});

$app->get('/teacher/{teacher_id}', function($teacher_id)
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