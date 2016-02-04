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
        $binder->SetStatusCode(201);
        $binder->SetResponseDataForTeacher($teacher);

    }
    else
    {
        $binder->SetStatusCode(409);
        $binder->SetResponseError(409,
            'Conflict',
            'Teacher can`t be saved .',
            'Teacher cannot be saved'
        );
    }
});

// аналогично app->post()
$app->put('teachers/{teacher_id}', function ($teacher_id) use ($app)
{
    /** @var stdClass $foo */
    $foo = $app->request->getJsonRawBody();

    /** @var Teacher $teacher*/
    $teacher = new Teacher(new \Dto\Teacher());
    $teacher->setId($teacher_id);
    $teacher->setNameFirst($foo->name_first);
    $teacher->setNameLast($foo->name_last);
    $teacher->setNameMiddle($foo->name_middle);
    $status = $teacher->update();

    $binder = new ResponseBinder();

    if($status)
    {
        $binder->SetStatusCode(201);
        $binder->SetResponseDataForTeacher($teacher);

    }
    else
    {
        $binder->SetStatusCode(409);
        $binder->SetResponseError(409,
            'Conflict',
            'Teacher can`t be saved .',
            'Teacher cannot be saved'
        );
    }
});

$app->delete('/teacher/{teacher_id}', function($teacher_id) use($app)
{
    $teacher = new Teacher(new \Dto\Teacher());
    $status = $teacher->delete();

    $binder = new ResponseBinder();
    if($status)
    {
        $binder->SetStatusCode(200);
        $binder->SetResponseDataForTeacher($teacher);
    }
    else
    {
        $binder->SetStatusCode(409);
        $binder->SetResponseError(409,
            'Conflict',
            'Teacher cannot be deleted',
            'Teacher cannot be deleted'
        );
    }
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

		$binder->SetResponseDataForTeacher($teachers);
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
        $binder->SetResponseDataForTeacher($teacher);
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

//----------------------------API Subject------------------------------------------------

$app->post('/subjects', function () use ($app)
{
    /** @var stdClass $foo */
    $foo = $app->request->getJsonRawBody();

    /** @var Subject $subject*/
    $subject = new Subject(new \Dto\Subject());
    $subject->setName($foo->name);
    $status = $subject->save();

    $binder = new ResponseBinder();

    if($status)
    {
        $binder->SetStatusCode(201);
        $binder->SetResponseDataForSubject($subject);

    }
    else
    {
        $binder->SetStatusCode(501);
        $binder->SetResponseError(501,
            'Conflict',
            'Subject can`t be saved .',
            'Subject with name cannot be saved'
        );
    }
});

$app->put('subjects/{subject_id}', function ($subject_id) use ($app)
{
    /** @var stdClass $foo */
    $foo = $app->request->getJsonRawBody();

    /** @var Subject $subject*/
    $subject = new Subject(new \Dto\Subject());
    $subject->setId($subject_id);
    $subject->setName($foo->name);
    $status = $subject->update();

    $binder = new ResponseBinder();

    if($status)
    {
        $binder->SetStatusCode(201);
        $binder->SetResponseDataForSubject($subject);

    }
    else
    {
        $binder->SetStatusCode(501);
        $binder->SetResponseError(501,
            'Conflict',
            'Subject can`t be updated .',
            'Subject with name cannot be updated'
        );
    }
});

$app->delete('/subjects/{id}', function($id) use($app)
{
    $subject = new Subject(new \Dto\Subject());
    $subject= Teacher::findById($id);
    $status = $subject->delete();

    $binder = new ResponseBinder();
    if($status)
    {
        $binder->SetStatusCode(200);
        $binder->SetResponseDataForTeacher($subject);
    }
    else
    {
        $binder->SetStatusCode(409);
        $binder->SetResponseError(409,
            'Conflict',
            'Subject cannot be deleted',
            'Subject cannot be deleted'
        );
    }
});

$app->get('/subjects', function() use ($app)
{
    /** @var Request $request */
    $request = new Request();
    if($request->has('name')) {
        $subjects = Subject::findByName($request->get('name'));
    }
    else
    {
        $subjects = Subject::find();
    }
    /** @var ResponseBinder $binder */
    $binder = new ResponseBinder();

    if($subjects)
    {

        $binder->SetResponseDataForSubject($subjects);
        $response = $binder->Bind();
    }
    else
    {
        $binder->SetStatusCode(404);
        $binder->SetResponseError(404,
            'NOT FOUND',
            'subject not found',
            'subject with name \''. $request->get('name') . '\' missing in database');
        $response = $binder->Bind();
    }

    return $response;
});

/**Get Subject by id*/
$app->get('/subjects/{subject_id}', function($subject_id)
{
    $subject = Subject::findById($subject_id);
    $binder = new ResponseBinder();

    if ($subject)
    {
        $binder->SetResponseDataForSubject($subject);
        $response = $binder->Bind();
    }
    else
    {
        $binder->SetResponseError(404,
            'NOT FOUND',
            'element not found',
            'teacher with id \''. $subject_id . '\' missing in database');
        $response = $binder->Bind();
    }

    return $response;
});

//----------------------------API SchoolRoom------------------------------------------------

$app->post('/school_rooms', function () use ($app)
{
    /** @var stdClass $foo */
    $foo = $app->request->getJsonRawBody();

    /** @var SchoolRoom $school_room*/
    $school_room = new SchoolRoom(new \Dto\SchoolRoom());
    $school_room->setName($foo->name);
    $status = $school_room->save();

    $binder = new ResponseBinder();

    if($status)
    {
        $binder->SetStatusCode(201);
        $binder->SetResponseDataForSchoolRoom($school_room);

    }
    else
    {
        $binder->SetStatusCode(409);
        $binder->SetResponseError(409,
            'Conflict',
            'Can`t be saved .',
            'SchoolRoom with name cannot be saved'
        );
    }
});

$app->put('school_rooms/{school_room_id}', function ($school_room_id) use ($app)
{
    /** @var stdClass $foo */
    $foo = $app->request->getJsonRawBody();

    /** @var SchoolRoom $school_room*/
    $school_room = new SchoolRoom(new \Dto\SchoolRoom());
    $school_room->setName($foo->name);
    $school_room->setId($school_room_id);
    $status = $school_room->save();

    $binder = new ResponseBinder();

    if($status)
    {
        $binder->SetStatusCode(201);
        $binder->SetResponseDataForSchoolRoom($school_room);

    }
    else
    {
        $binder->SetStatusCode(409);
        $binder->SetResponseError(409,
            'Conflict',
            'Can`t be saved .',
            'SchoolRoom with name cannot be saved'
        );
    }
});

$app->delete('/school_rooms/{school_room_id}', function($school_room_id) use($app)
{
    $school_room = new SchoolRoom(new \Dto\SchoolRoom());
    $status = $school_room->delete();

    $binder = new ResponseBinder();
    if($status)
    {
        $binder->SetStatusCode(200);
        $binder->SetResponseDataForSchoolRoom($school_room);
    }
    else
    {
        $binder->SetStatusCode(409);
        $binder->SetResponseError(409,
            'Conflict',
            'school_room cannot be deleted',
            'school_room cannot be deleted'
        );
    }
});

$app->get('/school_rooms', function() use ($app)
{
    /** @var Request $request */
    $request = new Request();
    if($request->has('name')) {
        $school_rooms = SchoolRoom::findByName($request->get('name'));
    }
    else
    {
        $school_rooms = SchoolRoom::find();
    }
    /** @var ResponseBinder $binder */
    $binder = new ResponseBinder();

    if($school_rooms)
    {

        $binder->SetResponseDataForSchoolRoom($school_rooms);
        $response = $binder->Bind();
    }
    else
    {
        $binder->SetStatusCode(404);
        $binder->SetResponseError(404,
            'NOT FOUND',
            'school_room not found',
            'school_room with name \''. $request->get('name') . '\' missing in database');
        $response = $binder->Bind();
    }

    return $response;
});

/**Get SchoolRoom by id*/
$app->get('/school_rooms/{school_room_id}', function($school_room_id)
{
    $school_room = SchoolRoom::findById($school_room_id);
    $binder = new ResponseBinder();

    if ($school_room)
    {
        $binder->SetResponseDataForSchoolRoom($school_room);
        $response = $binder->Bind();
    }
    else
    {
        $binder->SetResponseError(404,
            'NOT FOUND',
            'element not found',
            'teacher with id \''. $school_room_id . '\' missing in database');
        $response = $binder->Bind();
    }

    return $response;
});

//----------------------------API SchoolClass------------------------------------------------

$app->post('/school_classes', function () use ($app)
{
    /** @var stdClass $foo */
    $foo = $app->request->getJsonRawBody();

    /** @var SchoolClass $school_class*/
    $school_class = new SchoolRoom(new \Dto\SchoolRoom());
    $school_class->setName($foo->name);
    $status = $school_class->save();

    $binder = new ResponseBinder();

    if($status)
    {
        $binder->SetStatusCode(201);
        $binder->SetResponseDataForSchoolClass($school_class);

    }
    else
    {
        $binder->SetStatusCode(409);
        $binder->SetResponseError(409,
            'Conflict',
            'Can`t be saved .',
            'SchoolClass with name cannot be saved'
        );
    }
});

$app->put('school_classes/{school_classes_id}', function ($school_classes_id) use ($app)
{
    /** @var stdClass $foo */
    $foo = $app->request->getJsonRawBody();

    /** @var SchoolClass $school_class*/
    $school_class = new SchoolClass(new \Dto\SchoolClass());
    $school_class->setId($school_classes_id);
    $school_class->setName($foo->name);
    $status = $school_class->save();

    $binder = new ResponseBinder();

    if($status)
    {
        $binder->SetStatusCode(201);
        $binder->SetResponseDataForSchoolClass($school_class);

    }
    else
    {
        $binder->SetStatusCode(409);
        $binder->SetResponseError(409,
            'Conflict',
            'Can`t be saved .',
            'SchoolClass with name cannot be saved'
        );
    }
});

$app->delete('/school_classes/{id}', function($id) use($app)
{
    $school_class = new SchoolRoom(new \Dto\SchoolRoom());
    $status = $school_class->delete();

    $binder = new ResponseBinder();
    if($status)
    {
        $binder->SetStatusCode(200);
        $binder->SetResponseDataForSchoolClass($school_class);
    }
    else
    {
        $binder->SetStatusCode(409);
        $binder->SetResponseError(409,
            'Conflict',
            'school_class cannot be deleted',
            'school_class cannot be deleted'
        );
    }
});

$app->get('/school_classes', function() use ($app)
{
    /** @var Request $request */
    $request = new Request();
    if($request->has('name')) {
        $school_classes = SchoolClass::findByName($request->get('name'));
    }
    else
    {
        $school_classes = SchoolClass::find();
    }
    /** @var ResponseBinder $binder */
    $binder = new ResponseBinder();

    if($school_classes)
    {

        $binder->SetResponseDataForSchoolClass($school_classes);
        $response = $binder->Bind();
    }
    else
    {
        $binder->SetStatusCode(404);
        $binder->SetResponseError(404,
            'NOT FOUND',
            'school_class not found',
            'school_class with name \''. $request->get('name') . '\' missing in database');
        $response = $binder->Bind();
    }

    return $response;
});

/**Get SchoolClass by id*/
$app->get('/school_classes/{school_class_id}', function($school_class_id)
{
    $school_class = SchoolClass::findById($school_class_id);
    $binder = new ResponseBinder();

    if ($school_class)
    {
        $binder->SetResponseDataForSchoolClass($school_class);
        $response = $binder->Bind();
    }
    else
    {
        $binder->SetResponseError(404,
            'NOT FOUND',
            'element not found',
            'teacher with id \''. $school_class_id . '\' missing in database');
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

    public function SetResponseDataForTeacher($teachers)
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

    public function SetResponseDataForSubject($subjects)
    {
        /** @var Application $app*/
        global $app;
        $this->SetStatusCode(200);
        $data = [];

        if(is_array($subjects))
        {
            /** @var Subject $subject */
            foreach($subjects as $subject)
            {
                $data[] = $this->GetDataBySubject($subject);
            }
        }
        else
        {
            /** @var Subject $subjects */
            $data = $this->GetDataBySubject($subjects);
        }
        //$data[] = $this->GetRelationships();

        $this->data = $data;
        return $data;
    }

    public function SetResponseDataForSchoolRoom($school_rooms)
    {
        /** @var Application $app*/
        global $app;
        $this->SetStatusCode(200);
        $data = [];

        if(is_array($school_rooms))
        {
            /** @var SchoolRoom $school_room */
            foreach($school_rooms as $school_room)
            {
                $data[] = $this->GetDataBySchoolRoom($school_room);
            }
        }
        else
        {
            /** @var SchoolRoom $school_rooms */
            $data = $this->GetDataBySchoolRoom($school_rooms);
        }
        //$data[] = $this->GetRelationships();

        $this->data = $data;
        return $data;
    }

    public function SetResponseDataForSchoolClass($school_classes)
    {
        /** @var Application $app*/
        global $app;
        $this->SetStatusCode(200);
        $data = [];

        if(is_array($school_classes))
        {
            /** @var SchoolClass $school_class */
            foreach($school_classes as $school_class)
            {
                $data[] = $this->GetDataBySchoolClass($school_class);
            }
        }
        else
        {
            /** @var SchoolClass $school_classes */
            $data = $this->GetDataBySchoolClass($school_classes);
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

    /**
     *@var Subject $subject
     *@return array
     */
    public function GetDataBySubject($subject)
    {
        global $app;
        $data[] = [
            'type' => 'subject',
            'id' => $subject->getId(),
            'attributes' => [
                'title' => 'subject',
                'name' => $subject->getName(),
            ],
            'links' =>[
                'self' => $app->request->getURI() . '/' . $subject->getId()
            ]
        ];
        return $data;
    }

    /**
     *@var SchoolRoom $school_room
     *@return array
     */
    public function GetDataBySchoolRoom($school_room)
    {
        global $app;
        $data[] = [
            'type' => 'school_room',
            'id' => $school_room->getId(),
            'attributes' => [
                'title' => 'shool room',
                'name' => $school_room->getName(),
            ],
            'links' =>[
                'self' => $app->request->getURI() . '/' . $school_room->getId()
            ]
        ];
        return $data;
    }

    /**
     *@var SchoolClass $school_class
     *@return array
     */
    public function GetDataBySchoolClass($school_class)
    {
        global $app;
        $data[] = [
            'type' => 'school_class',
            'id' => $school_class->getId(),
            'attributes' => [
                'title' => 'school class',
                'name' => $school_class->getName(),
            ],
            'links' =>[
                'self' => $app->request->getURI() . '/' . $school_class->getId()
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