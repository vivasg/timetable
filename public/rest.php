<?php

defined('BASE_DIR') || define('BASE_DIR', dirname(__FILE__));
defined('APPS_DIR') || define('APPS_DIR', dirname(BASE_DIR) . DIRECTORY_SEPARATOR . 'apps' . DIRECTORY_SEPARATOR);

use \Phalcon\Mvc\Micro as Application,
	\Phalcon\Http\Response,
    \Phalcon\Di,
    \Phalcon\Http\Request,
    Phalcon\Exception as Exception;

$di = new Di();

require_once APPS_DIR . 'configs' . DIRECTORY_SEPARATOR . 'services.php';

$app = new Application();

//--------------------------------API Teacher--------------------------------

$app->post('/teachers{teacher_id}', function ($teacher_id) use ($app)
{
    /** @var stdClass $foo */
    $foo = $app->request->getJsonRawBody();

    $binder = new ResponseBinder();

    try
    {
        $teacher = Teacher::findById($teacher_id);
        if ($teacher == false)
        {
            throw new Exception();
        }
        $teacher->setNameFirst($foo->name_first);
        $teacher->setNameLast($foo->name_last);
        $teacher->setNameMiddle($foo->name_middle);
        $status = $teacher->update();
        if($status)
        {
            $binder->SetStatusCode(201);
            $binder->GetDataByObject($teacher);

        }
        else
        {
            $binder->SetStatusCode(501);
            $binder->SetResponseError(501,
                'Conflict',
                'Teacher can`t be saved .',
                'Teacher cannot be saved'
            );
        }
    }
    catch (Exception $e)
    {
        echo 'unknown error', $e->getMessage();

    }

});

// аналогично app->post()
$app->put('/teachers', function () use ($app)
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
        $binder->GetDataByObject($teacher);

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
    $binder = new ResponseBinder();

    try
    {
        $teacher = Teacher::findById($teacher_id);
        if ($teacher == false)
        {
            throw new Exception();
        }
        $status = $teacher->delete();
        if($status)
        {
            $binder->SetStatusCode(200);
            $binder->GetDataByObject($teacher);
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

    }
    catch (Exception $e)
    {
        echo 'unknown error', $e->getMessage();
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

		$binder->GetDataByObject($teachers);
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
        $binder->GetDataByObject($teacher);
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

$app->post('/subjects/{subject_id}', function ($subject_id) use ($app)
{
    /** @var stdClass $foo */
    $foo = $app->request->getJsonRawBody();
    $binder = new ResponseBinder();
    try
    {
        /** @var Subject $subject*/
        $subject = Subject::findById($subject_id);
        if ($subject == false)
        {
            throw new Exception;
        }

        $subject->setName($foo->name);
        $status = $subject->update();


        if($status)
        {
            $binder->SetStatusCode(201);
            $binder->GetDataByObject($subject);

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
    }
    catch (Exception $e)
    {
        echo 'Error', $e->getMessage();
    }

});

$app->put('/subjects', function () use ($app)
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
        $binder->GetDataByObject($subject);

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

$app->delete('/subjects/{id}', function($id) use($app)
{
    $binder = new ResponseBinder();

    try
    {
        /** @var Subject $subject */
        $subject= Subject::findById($id);
        if ($subject==false)
        {
            throw new Exception();
        }
        $status= $subject->delete();
        if($status)
        {
            $binder->SetStatusCode(200);
            $binder->GetDataByObject($subject);
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
    }
    catch(Exception $e)
    {
        echo 'unknown error', $e->getMessage();
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

        $binder->GetDataByObject($subjects);
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
        $binder->GetDataByObject($subject);
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

$app->post('/school_rooms/{school_room_id}', function ($school_room_id) use ($app)
{
    /** @var stdClass $foo */
    $foo = $app->request->getJsonRawBody();
    $binder = new ResponseBinder();

    try
    {
        /** @var SchoolRoom $school_room*/
        $school_room = SchoolRoom::findById($school_room_id);
        if($school_room == false)
        {
            throw new Exception;
        }
        $school_room->setName($foo->name);
        $status = $school_room->save();


        if($status)
        {
            $binder->SetStatusCode(201);
            $binder->GetDataByObject($school_room);

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
    }
    catch (Exception $e)
    {
        echo 'Error', $e->getMessage();
    }


});

$app->put('school_rooms/', function () use ($app)
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
        $binder->GetDataByObject($school_room);

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
    $binder = new ResponseBinder();

    try
    {
        $school_room = SchoolRoom::findById($school_room_id);
        if ($school_room == false)
        {
            throw new Exception();
        }
        $status = $school_room->delete();
        if($status)
        {
            $binder->SetStatusCode(200);
            $binder->GetDataByObject($school_room);
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
    }
    catch (Exception $e)
    {
        echo 'unknown error', $e->getMessage();
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

        $binder->GetDataByObject($school_rooms);
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

$app->post('/school_classes/{school_classes_id}', function ($school_classes_id) use ($app)
{
    /** @var stdClass $foo */
    $foo = $app->request->getJsonRawBody();
    $binder = new ResponseBinder();

    try
    {
        /** @var SchoolClass $school_class*/
        $school_class = SchoolClass::findById();
        if ($school_class == false)
        {
            throw new Exception;
        }
        $school_class->setName($foo->name);
        $status = $school_class->save();


        if($status)
        {
            $binder->SetStatusCode(201);
            $binder->GetDataByObject($school_class);

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
    }
    catch (Exception $e)
    {
        echo 'error', $e->getMessage();
    }

});

$app->put('school_classes/', function () use ($app)
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
        $binder->GetDataByObject($school_class);

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
    $binder = new ResponseBinder();

    try
    {
        $school_class = SchoolClass::findById($id);
        if ($school_class == false)
        {
            throw new Exception();
        }
        $status = $school_class->delete();
        if($status)
        {
            $binder->SetStatusCode(200);
            $binder->GetDataByObject($school_class);
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
    }
    catch (Exception $e)
    {
        echo 'Error', $e->getMessage();
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

        $binder->GetDataByObject($school_classes);
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
    $binder = new ResponseBinder();
    $school_class = SchoolClass::findById($school_class_id);

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

class ResponseBinder extends Getters
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
    public function SetResponseData($dataObject)
    {
        $data = [];
        if(is_array($dataObject))
        {
            /** @var Teacher $teacher */
            foreach($dataObject as $item)
            {
                $data[] = $this->GetDataByObject($item);
            }
        }
        else
        {
            /** @var Teacher $teachers */
            $data = $this->GetDataByObject($dataObject);
        }
        $this->data = $data;
        return $data;
    }

    /**
     * @param $object
     * @return array
     */
    public function GetDataByObject($object)
    {
        global $app;
        switch(get_class($object))
        {
            case 'Lesson':
                //return $this->GetShortLessonDataByObject($object);
                return $this->GetFullLessonDataByObject($object);
            case 'LessonDay':
                return $this->GetLessonDayDataByObject($object);
            case 'LessonWeek':
                return $this->GetLessonWeekDataByObject($object);
            case 'SchoolClass':
                return $this->GetSchoolClassDataByObject($object);
            case 'SchoolRoom':
                return $this->GetSchoolRoomDataByObject($object);
            case 'Subject':
                return $this->GetSubjectDataByObject($object);
            case 'Teacher':
                return $this->GetTeacherDataByObject($object);
            default:
                throw new InvalidArgumentException('unknown type: ' . get_class($object));
        }
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
class Getters
{
    protected function GetSchoolClassDataByObject($object)
    {
        /** @var SchoolClass $object */
        $data[] = [
            'type' => 'SchoolClass',
            'id' => $object->getId(),
            'attributes' => [
                'name' => $object->getName()
            ],
        ];
        return $data;
    }
    protected function GetTeacherDataByObject($object)
    {
        /** @var Teacher $object */
        $data[] = [
            'type' => 'Teacher',
            'id' => $object->getId(),
            'attributes' => [
                'title' => 'teacher',
                'name_first' => $object->getNameFirst(),
                'name_middle' => $object->getNameMiddle(),
                'name_last' => $object->getNameLast(),
                'name_full' => $object->getNameFull(),
                'name_short' => $object->getNameShort()
            ],
        ];
        return $data;
    }
    protected function GetSubjectDataByObject($object)
    {
        /** @var Subject $object */
        $data[] = [
            'type' => 'Subject', // спросить про заглавную букву(Subject или subject) касаеться всех запросов
            'id' => $object->getId(),
            'attributes' => [
                'name' => $object->getName(),
                'name_shortest' => $object->getShortestName(),
                'name_short' => $object->getShortName()
            ],
        ];
        return $data;
    }
    protected function GetShortLessonDataByObject($object)
    {
        /** @var Lesson $object */
        $data[] = [
            'type' => 'Lesson',
            'id' => $object->getId(),
            'attributes' => [
                'lesson_day_id' => $object->getLessonDayId(),
                'lesson_number' => $object->getLessonNumber(),
                'school_class_id' => $object->getSchoolClassId(),
                'subject_id' => $object->getSubjectId(),
                'school_room_id' => $object->getSchoolRoomId(),
                'teacher_id' => $object->getTeacherId()
            ],
        ];
        return $data;
    }
    protected function GetSchoolRoomDataByObject($object)
    {
        /** @var SchoolRoom $object */
        $data[] = [
            'type' => 'SchoolClass',
            'id' => $object->getId(),
            'attributes' => [
                'name' => $object->getName(),
            ],
        ];
        return $data;
    }
    protected function GetLessonDayDataByObject($object)
    {
        /** @var LessonDay $object */
        $data[] = [
            'type' => 'LessonDay',
            'id' => $object->getId(),
            'attributes' => [
                'lesson_week' => $this->GetLessonWeekDataByObject($object->getLessonWeek()),
                'week_day' => $object->getWeekday(),
                'name' => $object->getName(),
                'lesson_max_count' => $object->getLessonMaxCount(),
            ],
        ];
        return $data;
    }
    protected function GetLessonWeekDataByObject($object)
    {
        /** @var LessonWeek $object */
        $data[] = [
            'type' => 'LessonWeek',
            'id' => $object->getId(),
            'attributes' => [
                'number' => $object->getNumber(),
                'name' => $object->getName(),
            ],
        ];
        return $data;
    }
    protected function GetFullLessonDataByObject($object)
    {
        /** @var Lesson $object */
        $data[] = [
            'type' => 'Lesson',
            'id' => $object->getId(),
            'attributes' => [
                //'lesson_day' => $this->GetLessonWeekDataByObject($object->getLessonDay()), // failed! in database set null.
                'lesson_number' => $object->getLessonNumber(),
                'school_class' => $this->GetSchoolClassDataByObject($object->getSchoolClass()),
                'subject' => $this->GetSubjectDataByObject($object->getSubject()),
                'school_room' => $this->GetSchoolRoomDataByObject($object->getSchoolRoom()),
                'teacher' => $this->GetTeacherDataByObject($object->getTeacher()),
            ],
        ];
        return $data;
    }
}

$app->handle();