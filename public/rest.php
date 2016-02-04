<?php

mb_internal_encoding('UTF-8');
mb_http_output('UTF-8');
mb_http_input('UTF-8');
mb_regex_encoding('UTF-8');

defined('BASE_DIR') || define('BASE_DIR', dirname(__FILE__));
defined('APPS_DIR') || define('APPS_DIR', dirname(BASE_DIR) . DIRECTORY_SEPARATOR . 'apps' . DIRECTORY_SEPARATOR);

use \Phalcon\Mvc\Micro as Application,
	\Phalcon\Http\Response,
    \Phalcon\Di,
    \Phalcon\Http\Request;

$di = new Di();

//require_once '../apps/configs/services.php';
require_once APPS_DIR . 'configs' . DIRECTORY_SEPARATOR . 'services.php';

$app = new Application();

//--------------------------------API Teacher--------------------------------

// curl -i -X POST -d '{"name_first":"dio","name_last":"thor","name_middle":"nelos"}' http://timetable/api/teachers/
$app->post('/teachers', function () use ($app)
{
    /** @var stdClass $foo */
    $request = $app->request->getJsonRawBody();

    $binder = new ResponseBinder();
    try
    {
        /** @var Teacher $teacher*/
        $teacher = new Teacher(new \Dto\Teacher());

        if ($request->name_first)
        {
            $teacher->setNameFirst($foo->name_first);
        }
        if ($request->name_last)
        {
            $teacher->setNameLast($foo->name_last);
        }
        if ($request->name_middle)
        {
            $teacher->setNameMiddle($foo->name_middle);
        }
    }
    catch (Exception $ex)
    {
        $binder->SetStatusCode(400);
        var_dump($ex);
        // TODO: отправить стек клиенту
        return $binder->Bind();
    }

    $status = $teacher->save();

    if($status === true)
    {
        $binder->SetStatusCode(201);
        $binder->SetResponseData($teacher);
        return $binder->Bind();
    }
    else
    {
        $binder->SetStatusCode(400);
        return $binder->Bind();
    }
});

// curl -i -X PUT -d '{"name_first":"dio","name_last":"or","name_middle":"ns"}' http://timetable/api/teachers/16

$app->put('/teachers/{teacher_id:[0-9]+}', function ($teacher_id) use ($app)
{
    $binder = new ResponseBinder();
    $teacher = Teacher::findById($teacher_id);
    if(!$teacher)
    {
        $binder->SetStatusCode(404);
        $binder->SetResponseError(404,
            'NOT FOUND',
            'teacher not found',
            'teacher with id \''. $teacher_id . '\' missing in database');
        return $binder->Bind();
    }

    /** @var stdClass $foo */
    $request = $app->request->getJsonRawBody();

    try
    {
        // выбрасывает сообщение Undefinded property "..." если не передаем его в запрос
        // но иногда нам нужно изменить только одно поле класса и передаем в запрос 1 поле!
        // if не дает записать налл но выбрасываеться сообщение.. решить как игнорировать сообщения в данном блоке
        if ($request->name_first)
        {
            $teacher->setNameFirst($foo->name_first);
        }
        if ($request->name_last)
        {
            $teacher->setNameLast($foo->name_last);
        }
        if ($request->name_middle)
        {
            $teacher->setNameMiddle($foo->name_middle);
        }
    }
    catch(Exception $ex)
    {
        $binder->SetStatusCode(400);
        var_dump($ex);
        // TODO: отправить стек клиенту
        return $binder->Bind();
    }
    $status = $teacher->save();

    if($status === true)
    {
        $binder->SetStatusCode(202);
        $binder->SetResponseData($teacher);
        return $binder->Bind();
    }
    else
    {
        $binder->SetStatusCode(500);
        return $binder->Bind();
    }
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


$app->get('/teachers/{teacher_id:[0-9]+}', function($teacher_id)
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

$app->get('/lessons/{id:[0-9]+}', function($lessonId)
{
    try
    {
        $lesson = Lesson::findById($lessonId);
        $binder = new ResponseBinder();

        if ($lesson) {
            $binder->SetStatusCode(200);
            $binder->SetResponseData($lesson);
        } else {
            $binder->SetResponseError(400,
                'NOT EXIST',
                'element not exist',
                'lesson with id:' . $lessonId . ' does not exist');
        }
    }
    catch(Exception $ex)
    {
        var_dump($ex->getMessage());
        $binder->SetStatusCode(500);
    }
    return $binder->Bind();
});

// http://timetable/api/lessons/?subject=%D0%A4%D1%96%D0%B7%D0%B8%D0%BA%D0%B0
$app->get('/lessons', function() use ($app){
    //SubjectName
    //TeacherName
    $binder = new ResponseBinder();
    $request = new Request();
    if($request->has('subject'))
    {
        $subjectName = $request->get('subject');
        /** @var Subject|array $subjects */
        $subjects = Subject::findByName($subjectName);
        if ($subjects)
        {
            //$lessons;
            if(is_array($subjects))
            {
                /** @var Subject $subject */
                foreach ($subjects as $subject)
                {
                    $lessons = Lesson::findBySubjectId($subject->getId());
                }
            }
            else
            {
                $lessons = Lesson::findBySubjectId($subjects->getId());
            }
        }
    }
    elseif($request->has('teacher'))
    {
        $teacherName = $request->get('teacher');
        /** @var Teacher|array $teachers */
        $teachers = Teacher::findByName($teacherName);
        if(is_array($teachers))
        {
            $lessons = [];
            /** @var Teacher $teacher */
            foreach ($teachers as $teacher)
            {
                $lessons = array_merge($lessons, Lesson::findByTeacherId($teacher->getId()));
            }
        }
        else
        {
            $lessons = Lesson::findByTeacherId($teachers->getId());
        }
    }
    else
    {
        //??????
        $lessons = Lesson::getMany();
    }


    if($lessons)
    {
        $binder->SetStatusCode(200);
        $binder->SetResponseData($lessons);
        $response = $binder->Bind();
    }
    else
    {
        $binder->SetResponseError(404,
            'NOT FOUND',
            'lessons not found',
            'lessons not found in database');
        $response = $binder->Bind();
    }
    return $response;
});

// не работает решить!
// curl -i -X POST -d '{"lesson_day_id":"1", "lesson_number":"1", "school_class_id":"1", "subject_id":"1", "school_room_id":"1", "teacher_id":"1"}' http://timetable/api/lessons
$app->post('/lessons/{lesson_id:[0-9]+}', function($lesson_id) use ($app)
{

    $binder = new ResponseBinder();
    /** @var stdClass $foo */
    $request = $app->request->getJsonRawBody();
    //var_dump($request);
    try
    {
        $lesson = Lesson::findById($lesson_id);
        if(!$lesson)
        {
            $binder->SetResponseError(404, 'NOT FOUND', 'lesson not found', 'lesson with id:' . $lesson_id . ' not found');
            return $binder->Bind();
        }

        if (isset($request->lesson_day_id)) {
            $lesson->setLessonDayId(intval($request->lesson_day_id));
        }
        if (isset($request->lesson_number)) {
            $lesson->setLessonNumber(intval($request->lesson_number));
        }
        if (isset($request->school_class_id)) {
            $lesson->setSchoolClassId(intval($request->school_class_id));
        }
        if (isset($request->subject_id)) {
            $lesson->setSubjectId(intval($request->subject_id));
        }
        if (isset($request->school_room_id)) {
            $lesson->setSchoolRoomId(intval($request->school_room_id));
        }
        if (isset($request->teacher_id)) {
            $lesson->setTeacherId(intval($request->teacher_id));
        }
        $result = $lesson->save();
        if($result)
        {
            var_dump($result);
            $binder->SetResponseError(400, 'Bad Request', 'validation error', var_dump($request));
            return $binder->Bind();
        }
        else
        {
            $binder->SetStatusCode(200);
            $binder->SetResponseData($lesson);
            return $binder->Bind();
        }
    }
    catch(Exception $ex)
    {
        var_dump($ex->getMessage());
    }

});

// curl -i -X POST -d '{"lesson_day_id":"1", "lesson_number":"1", "school_class_id":"1", "subject_id":"1", "school_room_id":"1", "teacher_id":"1"}' http://timetable/api/lessons
$app->put('/lessons}', function($lesson_id) use ($app)
{
    $lesson = Lesson::findById($lesson_id);
    $request = $app->request->getJsonRawBody();

    if($request->lesson_day_id)
    {
        $lessonDay = LessonDay::findById($request->lesson_day_id);
        $lesson->setLessonDay($lessonDay);
        $lesson->setLessonDayId($lessonDay->getId() * 1);
    }
    if($request->lesson_number)
    {
        $lessomNumber = $request->lesson_number;
        $lesson->setLessonNumber($lessomNumber*1);
    }
    if($request->school_class_id)
    {
        /** @var SchoolClass $schoolClass */
        $schoolClass = SchoolClass::findById($request->school_class_id);
        $lesson->setSchoolClass($schoolClass);
        $lesson->setSchoolClassId($schoolClass->getId()*1);
    }
    if($request->subject_id)
    {
        $subject = Subject::findById($request->subject_id);
        $lesson->setSubject($subject);
        $lesson->setSubjectId($subject->getId()*1);
    }
    if($request->school_room_id)
    {
        $schoolRoom = SchoolRoom::findById($request->school_room_id);
        echo $schoolRoom->getName();
        $lesson->setSchoolRoom($schoolRoom);
        $lesson->setSchoolRoomId($schoolRoom->getId()*1);
    }
    if($request->teacher_id)
    {
        $teacher = Teacher::findById($request->teacher_id);
        $lesson->setTeacher($teacher);
        $lesson->setTeacherId($teacher->getId()*1);
    }
    $status = $lesson->save();
    var_dump($status);

    /*if()*/
    //echo $lesson->getLessonDay();
    var_dump($lesson->getLessonDayId());
    var_dump($lesson->getLessonDay()->getId());
    //var_dump($lessonDay instanceof LessonDay);
    //var_dump($request);

});

// curl -i -X DELETE http://timetable/api/lessons/1
$app->delete('/lessons/{lesson_id:[0-9]+}', function($lesson_id) use ($app){
    /** @var Lesson $lesson */
    $binder = new ResponseBinder();
    $lesson = Lesson::findById($lesson_id);
    if($lesson)
    {
        try
        {
            $lesson->delete();
            $binder->SetStatusCode(200);
        }
        catch(Exception $ex)
        {
            $binder->SetStatusCode(500);
        }
    }
    else
    {
        $binder->SetResponseError(404, 'NOT EXIST', 'Lesson not exist', 'Lesson with id:' . $lesson_id . ' not exist');
    }
    return $binder->Bind();
});

//--------------------------------API LessonDay--------------------------------

$app->get('/lessonDays', function() use ($app){
    // name
    $binder = new ResponseBinder();

    $request = new Request();
    if($request->has('name'))
    {
        $name = $request->get('name');
        $lessonDays = LessonDay::findByName($name);
    }
    else
    {
        $lessonDays = LessonDay::getMany(null);
    }
    if($lessonDays)
    {
        $binder->SetStatusCode(200);
        $binder->SetResponseData($lessonDays);
    }
    else
    {
        $binder->SetResponseError(404, 'NOT FOUND', 'Lesson Days not found', 'Lesson Days with name:' . $name . ' not found');
    }
    return $binder->Bind();
});

$app->get('/lessonDays/{lesson_day_id:[0-9]+}', function($lesson_day_id){

    $binder = new ResponseBinder();
    $lessonDay = LessonDay::findById($lesson_day_id);

    if($lessonDay)
    {
        $binder->SetStatusCode(200);
        $binder->SetResponseData($lessonDay);
    }
    else
    {
        $binder->SetResponseError(404, 'NOT EXIST', 'Lesson Day not exist', 'Lesson Day with id:' . $lesson_day_id . ' not exist');
    }
    return $binder->Bind();
});

// дописать...
// curl -i -X POST -d '{"lesson_week_id":"1", "wday":"1", "name":"Monday", "lesson_max_count":"8"}' http://timetable/api/lessonDays
$app->post('/lessonDays', function() use ($app){
    $binder = new ResponseBinder();
    $request = $app->request->getJsonRawBody();
    var_dump($request);
});

// дописать...
$app->put('/lessonDays/{lesson_day_id:[0-9]+}', function($lesson_day_id) use ($app){
    $binder = new ResponseBinder();
    /** @var LessonDay $lessonDay */
    $lessonDay= LessonDay::findById($lesson_day_id);



});

$app->delete('/lessonDays/{lesson_day_id:[0-9]+', function($lesson_day_id) use ($app){
    $binder = new ResponseBinder();
    $lessonDay = LessonDay::findById($lesson_day_id);

    if($lessonDay)
    {
        $binder->SetStatusCode(200);
        try
        {
            $lessonDay->delete();
        }
        catch(Exception $ex)
        {
            $binder->SetStatusCode(500);
        }
    }
    else
    {
        $binder->SetResponseError(404, 'NOT EXIST', 'Lesson Day not exist', 'Lesson Day with id:' . $lesson_day_id . ' not exist');
    }
    return $binder->Bind();
});


//--------------------------------API LessonWeek--------------------------------

$app->get('/lessonWeeks', function() use ($app){
    /** @var stdClass $foo */
    $request = new Request();
    //var_dump($request->get('number'));
    $binder = new ResponseBinder();
    if($request->has('name') && $request->has('number'))
    {
        $parameters = [
            'conditions' => 'number=:number: AND name=:name:',
            'bind' => [
                'number' => $request->get('number'),
                'name' => $request->get('name')
            ],
        ];
    }
    elseif($request->has('number'))
    {
        $parameters = [
            'conditions' => 'number=:number:',
            'bind' => [
                'number' => $request->get('number')
            ],
        ];
    }
    elseif($request->has('name'))
    {
        $parameters = [
            'conditions' => 'name=:name:',
            'bind' => [
                'name' => $request->get('name')
            ],
        ];
    }
    else
    {
     $lessonWeeks = LessonWeek::getMany(null);
    }
    if(!$lessonWeeks)
    {
        $lessonWeeks = LessonWeek::getMany($parameters);
    }
    //var_dump($lessonWeeks);
    if($lessonWeeks)
    {
        $binder->SetStatusCode(200);
        $binder->SetResponseData($lessonWeeks);
    }
    else
    {

    }
    return $binder->Bind();
});

$app->get('/lessonWeeks/{lesson_week_id:[0-9]+}', function($lesson_week_id){
    $binder = new ResponseBinder();
    $lessonWeek = LessonWeek::findById($lesson_week_id);

    if ($lessonWeek instanceof LessonWeek) {
        $binder->SetStatusCode(200);
        $binder->SetResponseData($lessonWeek);
    } else {
        $binder->SetStatusCode(404);
        $binder->SetResponseError(404, 'NOT EXIST', 'lesson week not exist', 'lesson week with id:' . $lesson_week_id . ' does not exist');
    }
    $response = $binder->Bind();
    return $response;
});

// curl -i -X POST -d '{"number":"2", "name":"second week"}' http://timetable/api/lessonWeeks
$app->post('/lessonWeeks', function() use ($app){
    $binder = new ResponseBinder();
    $request = $app->request->getJsonRawBody();
    //var_dump($request);
    $lessonWeek = new LessonWeek(new \Dto\LessonWeek());
    try
    {
        if ($request->name) {
            $lessonWeek->setName($request->name);
        }
        if ($request->number) {
            $lessonWeek->setNumber($request->number * 1);
        }
    }
    catch (Exception $ex)
    {
        $binder->SetStatusCode(500);
        return $binder->Bind();
    }
    try
    {
        $status = $lessonWeek->save();
    }
    catch(PDOException $ex)
    {
        $status = null;
        $binder->SetResponseError(400, 'BAD REQUEST', 'problem with data', $ex->errorInfo);
        return  $binder->Bind();
    }
    catch(Exception $ex)
    {
        $status = null;
        $binder->SetStatusCode(500);
    }
    if($status)
    {
        $binder->SetStatusCode(500);
    }
    else
    {
        $binder->SetStatusCode(200);
    }
    return $binder->Bind();
});

// curl -i -X PUT -d '{"number":"1", "name":"first week"}' http://timetable/api/lessonWeeks/1
$app->put('/lessonWeeks/{lesson_week_id:[0-9]+}', function($lesson_week_id) use ($app){
    $binder = new ResponseBinder();
    /** @var LessonWeek $lessonWeek */
    $lessonWeek = LessonWeek::findById($lesson_week_id);

    $request = $app->request->getJsonRawBody();
    try
    {
        if ($lessonWeek) {
            if ($request->name) {
                $lessonWeek->setName($request->name);
            }
            if ($request->number) {
                $lessonWeek->setNumber($request->number * 1);
            }
            $status = $lessonWeek->save();
            if ($status) {
                $binder->SetResponseError(400, 'NOT VALID', 'request have invalid data', $status);
            }
            $binder->SetStatusCode(200);
        } else {
            $binder->SetResponseError(404, 'NOT EXIST', 'Lesson Week not exist', 'Lesson Week with id:' . $lesson_week_id . ' not exist');

        }
    }
    catch(Exception $ex)
    {
        $binder->SetStatusCode(500);
    }
    return $binder->Bind();
});

// curl -i -X DELETE http://timetable/api/LessonWeeks/1
$app->delete('/lessonWeeks/{lesson_week_id:[0-9]+}', function($lesson_week_id) use ($app){
    $binder = new ResponseBinder();
    /** @var LessonWeek $lessonWeek */
    $lessonWeek = LessonWeek::findById($lesson_week_id);

    if($lessonWeek)
    {
        try
        {
            $lessonWeek->delete();
            $binder->SetStatusCode(200);
        }
        catch(Exception $ex)
        {
            $binder->SetStatusCode(500);
        }
    }
    else
    {
        $binder->SetResponseError(404, 'NOT EXIST', 'Lesson Week not exist', 'Lesson Week with id:' . $lesson_week_id . ' not exist ');
    }
    return $binder->Bind();
});


class ResponseBinder
{
    /** @var Response $response */
    private $response;
    /** @var array $data */
    public $data;
    private $relationships;
    private $responseError;
    private $serverErrors;
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
        elseif($statusCode == '404 Not Found')
        {
            $this->response->setJsonContent($this->responseError);
        }
        elseif( $statusCode == '400 Bad Request')
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
        else
        {
            $this->SetStatusCode(500);
            $this->response->setJsonContent('Server error');

        }
        return $this->response;
    }

    public function SetStatusCode($statusCode)
    {
        $this->response->setStatusCode($statusCode);
    }

    /**
     * @param array|object $dataObject
     * @return array
     */
    public function SetResponseData($dataObject)
    {
        $data = [];
        if(is_array($dataObject))
        {
            $count = 0;
            /** @var Lesson|Teacher|Subject|LessonWeek|LessonDay|SchoolRoom|SchoolClass $item */
            foreach($dataObject as $item)
            {
                $data[] = $item->GetResponseData();
               // echo $item->getId();
            }
        }
        else
        {
            $data = $dataObject->GetResponseData();
        }
        $this->data = $data;
        //var_dump($this->data);
        return $data;
    }

    public function SetServerErrors()
    {

    }
    /**
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
        $this->SetStatusCode(intval($http_code));
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