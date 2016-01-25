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

    if($status)
    {
        $binder->SetStatusCode('201 CREATED');
        $binder->SetResponseData($teacher);

    }
    else
    {

    }
});

// аналогично app->post()
$app->put('teachers/{id}', function ($id) use ($app)
{

});

$app->delete('/teacher/{id}', function($id) use($app)
{

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

/**Get Teacher by id*/
$app->get('/teachers/{teacher_id}', function($teacher_id)
{
	$teacher = Teacher::findById($teacher_id);
    $binder = new ResponseBinder();

	if ($teacher)
	{
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
        //  var_dump($statusCode);
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
        elseif($statusCode = '404 NOT FOUND')
        {
            $this->response->setJsonContent($this->responseError);
        }
        elseif($statusCode = '201 CREATED')
        {
            $this->response =[

            ];
        }
        return $this->response;
    }

    public function SetStatusCode($statusCode)
    {
        $this->response->setStatusCode($statusCode);
    }

    public function SetResponseData($teachers)
    {
        /** @var Application $app*/
        global $app;
        $this->SetStatusCode(200);
        $data = [];

        if(is_array($teachers))
        {
            /** @var Teacher $teacher */
            foreach($teachers as $teacher)
            {
                $data[] = $this->GetDataByTeacher($teacher);
            }
        }
        else
        {
            /** @var Teacher $teachers */
            $data = $this->GetDataByTeacher($teachers);
        }
        //$data[] = $this->GetRelationships();

        $this->data = $data;
        return $data;
    }
    /**
     *@var Teacher $teacher
     *@return array
     */
    public function GetDataByTeacher($teacher)
    {
        global $app;
        $data[] = [
            'type' => 'teacher',
            'id' => $teacher->getId(),
            'attributes' => [
                'title' => 'teacher',
                'name_first' => $teacher->getNameFirst(),
                'name_middle' => $teacher->getNameMiddle(),
                'name_last' => $teacher->getNameLast(),
            ],
            'links' =>[
                'self' => $app->request->getURI() . '/' . $teacher->getId()
            ]
        ];
        return $data;
    }
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