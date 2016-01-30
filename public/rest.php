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
     *@var Teacher $teacher
     *@return array
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
            'id'    => $object->getId(),
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