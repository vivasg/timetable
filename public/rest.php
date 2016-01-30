<?php

defined('BASE_DIR') || define('BASE_DIR', dirname(__FILE__));
defined('APPS_DIR') || define('APPS_DIR', dirname(BASE_DIR) . DIRECTORY_SEPARATOR . 'apps' . DIRECTORY_SEPARATOR);

use \Phalcon\Mvc\Micro as Application,
	\Phalcon\Http\Response,
    \Phalcon\Di,
    \Phalcon\Http\Request;

$di = new Di();

require_once APPS_DIR . 'configs' . DIRECTORY_SEPARATOR . 'services.php';

$app = new Application();

//--------------------------------API Teacher--------------------------------

// curl -i -X POST -d '{"name_first":"dio","name_last":"thor","name_middle":"nelos"}' http://timetable/api/teachers/
$app->post('/teachers', function () use ($app)
{
    /** @var stdClass $foo */
    $foo = $app->request->getJsonRawBody();
    /** @var Teacher $teacher*/
    $teacher = new Teacher(new \Dto\Teacher());
    $teacher->setNameFirst($foo->name_first);
    $teacher->setNameLast($foo->name_last);
    $teacher->setNameMiddle($foo->name_middle);
    $status = $teacher->save();
    $binder = new ResponseBinder();

    if($status === true)
    {
        $binder->SetStatusCode(201);
        $binder->SetResponseData($teacher);
        $response = $binder->Bind();
    }
    else
    {
        $binder->SetStatusCode(400);
        $response = $binder->Bind();
    }
    return $response;
});

// curl -i -X PUT -d '{"name_first":"dio","name_last":"thor","name_middle":"ns"}' http://timetable/api/teachers/16
$app->put('/teachers/{teacher_id:[0-9]+}', function ($teacher_id) use ($app)
{
    $teacher = Teacher::findById($teacher_id);
    /** @var stdClass $foo */
    $foo = $app->request->getJsonRawBody();
    $teacher->setNameFirst($foo->name_first);
    $teacher->setNameLast($foo->name_last);
    $teacher->setNameMiddle($foo->name_middle);
    $status = $teacher->save();
    $binder = new ResponseBinder();

    if($status === true)
    {
        $binder->SetStatusCode(202);
        $binder->SetResponseData($teacher);
        $response = $binder->Bind();
    }
    else
    {

    }
    return $response;
});
// curl -i -X DELETE http://timetable/api/teachers/16
$app->delete('/teachers/{teacher_id:[0-9]+}', function($teacher_id) use($app)
{
    $teacher = Teacher::findById($teacher_id);
    $binder = new ResponseBinder();
    if($teacher)
    {
        $binder->SetResponseData($teacher);
        $teacher->delete();
        $binder->SetStatusCode(202);
    }
    else
    {
        $binder->SetStatusCode(404);
        $binder->SetResponseError(404,
            'NOT FOUND',
            'teacher not found',
            'teacher with id \''. $teacher_id . '\' missing in database');
    }
    $response = $binder->Bind();
    return $response;

    
});

$app->get('/teachers', function() use ($app)
{
    /** @var Request $request */
    $request = new Request();
    if($request->has('name')) {
        $teachers = Teacher::findByName($request->get('name'));
    }
    else
    {
        $teachers = Teacher::find();
    }
    /** @var ResponseBinder $binder */
    $binder = new ResponseBinder();

	if($teachers)
	{
        $binder->SetStatusCode(200);
		$binder->SetResponseData($teachers);
        $response = $binder->Bind();
	}
	else
	{
        $binder->SetStatusCode(404);
        $binder->SetResponseError(404,
            'NOT FOUND',
            'teacher not found',
            'teacher with name \''. $request->get('name') . '\' missing in database');
        $response = $binder->Bind();
	}

	return $response;
});


$app->get('/teachers/{teacher_id}', function($teacher_id)
{
	$teacher = Teacher::findById($teacher_id);
    $binder = new ResponseBinder();

	if ($teacher)
	{
        $binder->SetStatusCode(200);
        $binder->SetResponseData($teacher);
        $response = $binder->Bind();
	}
	else
	{
        $binder->SetResponseError(404,
            'NOT FOUND',
            'element not found',
            'teacher with id \''. $teacher_id . '\' missing in database');
        $response = $binder->Bind();
    }

	return $response;
});

//--------------------------------API Lesson--------------------------------

$app->get('/lessons/{id}', function($lessonId)
{
    $lesson = Lesson::findById($lessonId);
    $binder = new ResponseBinder();

    if($lesson)
    {
        $binder->SetStatusCode(200);
        $binder->SetResponseData($lesson);
        $response = $binder->Bind();
    }
    else
    {
        $binder->SetResponseError(404,
            'NOT FOUND',
            'element not found',
            'lesson with id \''. $lessonId . '\' missing in database');
        $response = $binder->Bind();
    }
    return $response;
});

$app->get('/lessons', function() use ($app){

});

$app->post('/lessons', function() use ($app){

});

$app->put('/lessons', function() use ($app){

});

$app->delete('/lesson', function() use ($app){

});

//--------------------------------API LessonDay--------------------------------

$app->get('/lessonDays', function() use ($app){

});

$app->get('/lessonDays/{id}', function($lessonDayId){

});

$app->post('/lessonDays', function() use ($app){

});

$app->put('/lessonDays', function() use ($app){

});

$app->delete('/lessonDays', function() use ($app){

});


//--------------------------------API LessonWeek--------------------------------

$app->get('/LessonWeeks', function() use ($app){

});

$app->get('/LessonWeeks/{id}', function($lessonId){

});

$app->post('/LessonWeeks', function() use ($app){

});

$app->put('/LessonWeeks', function() use ($app){

});

$app->delete('/LessonWeeks', function() use ($app){

});

class ResponseBinder
{
    /** @var Response $response */
    private $response;
    /** @var array $data */
    private $data;
    private $relationships;
    private $responseError;

    /**
     * Binder constructor.
     * @param string|null $contentType default response content type = 'application/vnd.api+json'
     */
    public function __construct($contentType = 'application/vnd.api+json')
    {
        $this->response = new Response();
        $this->response->setContentType($contentType);
    }
    public function Bind()
    {
        $this->SetRelationships();
        global $app;
        $statusCode = $this->response->getStatusCode();
        //var_dump($statusCode);

        if($statusCode == '200 OK') {
            $this->response->setJsonContent([
                'links' => [
                    'self' => $app->url->path($app->request->getURI()),
                ],
                'data' => $this->data,
                'relationships' => $this->relationships,
                'meta' => $this->GetMeta(),
            ]);
        }
        elseif($statusCode == '404 NOT FOUND')
        {
            $this->response->setJsonContent($this->responseError);
        }
        elseif($statusCode == '201 Created')
        {
            $this->response->setJsonContent([
                'links' => [
                    'self' => $app->url->path($app->request->getURI()),
                ],
                'data' => $this->data,
                'meta' => $this->GetMeta(),
            ]);
        }
        elseif($statusCode == '202 Accepted')
        {
            $this->response->setJsonContent([
                'links' => [
                    'self' => $app->url->path($app->request->getURI()),
                ],
                'data' => '',
                'meta' => $this->GetMeta(),
            ]);
        }

        return $this->response;
    }

    public function SetStatusCode($statusCode)
    {
        $this->response->setStatusCode($statusCode);
    }

    public function SetResponseData($dataObject)
    {
        $data = [];

        if(is_array($dataObject))
        {
            /** @var Teacher $item */
            foreach($dataObject as $item)
            {
                $data[] = $item->GetResponseData();
            }
        }
        else
        {
            /** @var Teacher $teachers */
            $data = $dataObject->GetResponseData();
        }

        $this->data = $data;
        return $data;
    }
    /**
     *@var Teacher $teacher
     *@return array
     */

    public function SetRelationships()
    {
        /** @var \Phalcon\Mvc\Micro $app */
        $relationships = [
            'author' => [
                'links' => [
                    'self' => '',
                    'related' => '',
                ],
                'data'=> [

                ]
            ]
        ];
        $this->relationships = $relationships;
        return $relationships;
    }

    public function GetMeta()
    {
        $meta = [
            'copyright' => 'Copyright 2016 Banda Corp.',
            'authors' => [
                'Yehuda Katz',
                'Steve Klabnik',
                'Dan Gebhardt',
                'Tyler Kellen'
            ]
        ];
        return $meta;
    }

    /**
     * @param int $http_code
     * @param string $http_status
     * @param string $error_title
     * @param string $error_description
     * @return array
     */
    public function SetResponseError($http_code, $http_status, $error_title, $error_description)
    {
        $this->SetStatusCode(404);
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
            'source' => 0,
            'meta' => $this->GetMeta(),
        ];
        $this->responseError = $response;
        return $response;
    }
}

$app->handle();