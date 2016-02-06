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

// curl -i -X PUT -d '{"name_first":"dio","name_last":"or","name_middle":"ns"}' http://timetable/api/teachers/16
$app->put('/teachers', function () use ($app)
{
    /** @var stdClass $foo */
    $request = $app->request->getJsonRawBody();

    $binder = new ResponseBinder();
    try
    {
        /** @var Teacher $teacher*/
        $teacher = new Teacher();

        if ($request->name_first)
        {
            $teacher->setNameFirst($request->name_first);
        }
        if ($request->name_last)
        {
            $teacher->setNameLast($request->name_last);
        }
        if ($request->name_middle)
        {
            $teacher->setNameMiddle($request->name_middle);
        }
        $status = $teacher->create();

        if($status === false)
        {
            $binder->SetStatusCode(201);
            $binder->SetResponseData($teacher);
            return $binder->Bind();
        }
        else
        {
            $err = '';
            /** @var \Phalcon\Mvc\Model\MessageInterface $stat */
            foreach ($status as $stat) {
                $err = $err . $stat->getMessage();
            }
            $binder->SetResponseError(400,
                'Bad Request',
                'The server cannot or will not process the request due to something that is perceived to be a client error',
                $err);
            return $binder->Bind();
        }
    }
    catch (Exception $ex)
    {
        $binder->SetResponseError(500,
            'Server Error',
            'Internal Server Error',
            $ex->getMessage());
        return $binder->Bind();
    }


});


// curl -i -X POST -d '{"name_first":"dio","name_last":"thor","name_middle":"nelos"}' http://timetable/api/teachers/
$app->post('/teachers/{teacher_id:[0-9]+}', function ($teacher_id) use ($app)
{
    /** @var stdClass $foo */
    $request = $app->request->getJsonRawBody();
    $binder = new ResponseBinder();
    try
    {
        $teacher = Teacher::findById($teacher_id);
        if (!$teacher)
        {
            $binder->SetStatusCode(404);
            $binder->SetResponseError(404,
                'NOT FOUND',
                'teacher not found',
                'teacher with id \'' . $teacher_id . '\' missing in database');
            return $binder->Bind();
        }


        if (isset($request->name_first))
        {
            $teacher->setNameFirst($request->name_first);
        }
        if (isset($request->name_last))
        {
            $teacher->setNameLast($request->name_last);
        }
        if (isset($request->name_middle))
        {
            $teacher->setNameMiddle($request->name_middle);
        }
        /** @var bool|\Phalcon\MVC\Model\MessageInterface $status */
        $status = $teacher->update();

        if ($status === false)
        {
            $binder->SetStatusCode(200);
            $binder->SetResponseData($teacher);
            return $binder->Bind();
        }
        else
        {
            $err = '';
            /** @var \Phalcon\Mvc\Model\MessageInterface $stat */
            foreach ($status as $stat) {
                $err = $err . $stat->getMessage();
            }
            //var_dump($err);
            $binder->SetResponseError(400,
                'Bad Request',
                'The server cannot or will not process the request due to something that is perceived to be a client error',
                $err);
            return $binder->Bind();
        }
    }
    catch(Exception $ex)
    {
        $binder->SetResponseError(500,
            'Server error',
            'Internal Server Error',
            $ex->getMessage());

        return $binder->Bind();
    }
});

// curl -i -X DELETE http://timetable/api/teachers/16
$app->delete('/teachers/{teacher_id:[0-9]+}', function($teacher_id) use($app)
{
    $binder = new ResponseBinder();

    try
    {
        $teacher = Teacher::findById($teacher_id);
        if (!$teacher)
        {
            $binder->SetResponseError(404,
                'NOT FOUND',
                'teacher not found',
                'teacher with id \'' . $teacher_id . '\' missing in database');
            return $binder->Bind();
        }
        $response = $teacher->delete();

        if ($response === true)
        {
            $binder->SetStatusCode(200);
            $binder->SetResponseData($teacher);
            return $binder->Bind();
        }
        else
        {
            $binder->SetResponseError(500,
                'Server Error',
                'Internal Server Error',
                'Resourse not be deleted');
            return $binder->Bind();
        }
    }
    catch(Exception $ex)
    {
        $binder->SetResponseError(500,
            'Server error',
            'Internal Server Error',
            $ex->getMessage());

        return $binder->Bind();
    }
});

$app->get('/teachers', function() use ($app)
{
    /** @var Request $request */
    $request = new Request();
    /** @var ResponseBinder $binder */
    $binder = new ResponseBinder();
    try
    {
        if ($request->has('name'))
        {
            $teachers = Teacher::findByName($request->get('name'));
            if (!$teachers)
            {
                $binder->SetStatusCode(200);
                return $binder->Bind();
            }
        }
        else
        {
            $teachers = Teacher::find();
        }

        if ($teachers) {
            $binder->SetStatusCode(200);
            $binder->SetResponseData($teachers);
            return $binder->Bind();
        }
        else
        {
            $binder->SetStatusCode(200);
            return $binder->Bind();
        }
    }
    catch(Exception $ex)
    {
        $binder->SetResponseError(500,
            'Server error',
            'Internal Server Error',
            $ex->getMessage());

        return $binder->Bind();
    }
});


$app->get('/teachers/{teacher_id:[0-9]+}', function($teacher_id)
{
    $binder = new ResponseBinder();
    try
    {
        $teacher = Teacher::findById($teacher_id);
        if ($teacher)
        {
            $binder->SetStatusCode(200);
            $binder->SetResponseData($teacher);
            return $binder->Bind();
        }
        else
        {
            $binder->SetStatusCode(200);
            return $binder->Bind();
        }
    }
    catch(Exception $ex)
    {
        $binder->SetResponseError(500,
            'Server error',
            'Internal Server Error',
            $ex->getMessage());
        return $binder->Bind();
    }
});

//--------------------------------API Lesson--------------------------------

$app->get('/lessons/{id:[0-9]+}', function($lessonId)
{
    $binder = new ResponseBinder();
    try
    {
        $lesson = Lesson::findById($lessonId);

        if ($lesson)
        {
            $binder->SetStatusCode(200);
            $binder->SetResponseData($lesson);
            return $binder->Bind();
        }
        else
        {
            $binder->SetStatusCode(200);
            return $binder->Bind();
        }
    }
    catch(Exception $ex)
    {
        $binder->SetResponseError(500,
            'Server Error',
            'Internal Server Error',
            $ex->getMessage());
        return $binder->Bind();
    }
});

// http://timetable/api/lessons/?subject=%D0%A4%D1%96%D0%B7%D0%B8%D0%BA%D0%B0
$app->get('/lessons', function() use ($app) {
    //SubjectName
    //TeacherName
    $binder = new ResponseBinder();
    $request = new Request();
    try
    {
        $lessons=[];
        if ($request->has('subject'))
        {
            $subjectName = $request->get('subject');
            /** @var Subject|array $subjects */
            $subjects = Subject::findByName($subjectName);
            if ($subjects)
            {
                //$lessons;
                if (is_array($subjects))
                {
                    $lessons = [];
                    /** @var Subject $subject */
                    foreach ($subjects as $subject)
                    {
                        $lessons = array_merge($lessons,  Lesson::findBySubjectId($subject->getId()));
                    }
                }
                else
                {
                    $lessons = Lesson::findBySubjectId($subjects->getId());
                }
            }
        }
        elseif ($request->has('teacher'))
        {
            $teacherName = $request->get('teacher');
            /** @var Teacher|array $teachers */
            $teachers = Teacher::findByName($teacherName);
            if($teachers)
            {
                if (is_array($teachers))
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
        }
        else
        {
            $lessons = Lesson::getMany();
        }


        if ($lessons)
        {
            $binder->SetStatusCode(200);
            $binder->SetResponseData($lessons);
            return $binder->Bind();
        }
        else
        {
            $binder->SetStatusCode(200);
            return $binder->Bind();
        }
    }
    catch(Exception $ex)
    {
        $binder->SetResponseError(500,
            'Server Error',
            'Internal Server Error',
            $ex->getMessage());
        return $binder->Bind();
    }
});

// curl -i -X POST -d '{"lesson_day_id":"1", "lesson_number":"1", "school_class_id":"1", "subject_id":"1", "school_room_id":"1", "teacher_id":"1"}' http://timetable/api/lessons
$app->post('/lessons/{lesson_id:[0-9]+}', function($lesson_id) use ($app)
{
    $binder = new ResponseBinder();
    /** @var stdClass $foo */
    $request = $app->request->getJsonRawBody();
    try
    {
        $lesson = Lesson::findById($lesson_id);
        if (!$lesson)
        {
            $binder->SetResponseError(404, 'NOT FOUND', 'lesson not found', 'lesson with id:' . $lesson_id . ' not found');
            return $binder->Bind();
        }

        if (isset($request->lesson_day_id))
        {
            if (is_numeric($request->lesson_day_id) )
            {
                $lesson->setLessonDayId(intval($request->lesson_day_id));
            }
            else
            {
                throw new InvalidArgumentException('Incorect lesson_day_id:' . $request->lesson_day_id . ', lesson_day_id accept only integer');
            }
        }
        if (isset($request->lesson_number))
        {
            if (is_numeric($request->lesson_number))
            {
                $lesson->setLessonNumber(intval($request->lesson_number));
            }
            else
            {
                throw new InvalidArgumentException('Incorect lesson_number:' . $request->lesson_number . ', lesson_number accept only integer');
            }
        }
        if (isset($request->school_class_id))
        {
            if (is_numeric($request->school_class_id))
            {
                $lesson->setSchoolClassId(intval($request->school_class_id));
            }
            else
            {
                throw new InvalidArgumentException('Incorect school_class_id:' . $request->school_class_id . ', school_class_id accept only integer');
            }
        }
        if (isset($request->subject_id))
        {
            if (is_numeric($request->subject_id))
            {
                $lesson->setSubjectId(intVal($request->subject_id));
            }
            else
            {
                throw new InvalidArgumentException('Incorect subject_id:' . $request->subject_id . ', subject_id accept only integer');
            }
        }
        if (isset($request->school_room_id))
        {
            if (is_numeric($request->school_room_id))
            {
                $lesson->setSchoolRoomId(intval($request->school_room_id));
            }
            else
            {
                throw new InvalidArgumentException('Incorect school_room_id:' . $request->school_room_id . ', school_room_id accept only integer');
            }
        }
        if (isset($request->teacher_id))
        {
            if (is_numeric($request->teacher_id))
            {
                $lesson->setTeacherId(intval($request->teacher_id));
            }
            else
            {
                throw new InvalidArgumentException('Incorect teacher_id:' . $request->teacher_id . ', teacher_id accept only integer');
            }
        }

        $status = $lesson->update();

        if($status)
        {
            $err = '';
            /** @var \Phalcon\Mvc\Model\MessageInterface $stat */
            foreach ($status as $stat)
            {
                $err = $err . ' ' . $stat->getMessage();
            }
            $binder->SetResponseError(400,
                'Bad Request',
                'The server cannot or will not process the request due to something that is perceived to be a client error',
                $err);
            return $binder->Bind();
        }
        else
        {
            $binder->SetStatusCode(200);
            $binder->SetResponseData($lesson);
            return $binder->Bind();
        }
    }
    catch(InvalidArgumentException $ex)
    {
        $binder->SetResponseError(400,
            'Bad Request',
            'The server cannot or will not process the request due to something that is perceived to be a client error',
            $ex->getMessage());
        return $binder->Bind();
    }
    catch(Exception $ex)
    {
        $binder->SetResponseError(500,
            'Server Error',
            'Internal Server Error',
            $ex->getMessage());
        return $binder->Bind();
    }
});

// curl -i -X POST -d '{"lesson_day_id":"1", "lesson_number":"1", "school_class_id":"1", "subject_id":"1", "school_room_id":"1", "teacher_id":"1"}' http://timetable/api/lessons
$app->put('/lessons', function() use ($app)
{
    $request = $app->request->getJsonRawBody();
    $binder = new ResponseBinder();

    try
    {
        $lesson = new Lesson();
        if (isset($request->lesson_day_id))
        {
            if (is_numeric($request->lesson_day_id) )
            {
                $lesson->setLessonDayId(intval($request->lesson_day_id));
            }
            else
            {
                throw new InvalidArgumentException('Incorect lesson_day_id:' . $request->lesson_day_id . ', lesson_day_id accept only integer');
            }
        }
        if (isset($request->lesson_number))
        {
            if (is_numeric($request->lesson_number))
            {
                $lesson->setLessonNumber(intval($request->lesson_number));
            }
            else
            {
                throw new InvalidArgumentException('Incorect lesson_number:' . $request->lesson_number . ', lesson_number accept only integer');
            }
        }
        if (isset($request->school_class_id))
        {
            if (is_numeric($request->school_class_id))
            {
                $lesson->setSchoolClassId(intval($request->school_class_id));
            }
            else
            {
                throw new InvalidArgumentException('Incorect school_class_id:' . $request->school_class_id . ', school_class_id accept only integer');
            }
        }
        if (isset($request->subject_id))
        {
            if (is_numeric($request->subject_id))
            {
                $lesson->setSubjectId(intVal($request->subject_id));
            }
            else
            {
                throw new InvalidArgumentException('Incorect subject_id:' . $request->subject_id . ', subject_id accept only integer');
            }
        }
        if (isset($request->school_room_id))
        {
            if (is_numeric($request->school_room_id))
            {
                $lesson->setSchoolRoomId(intval($request->school_room_id));
            }
            else
            {
                throw new InvalidArgumentException('Incorect school_room_id:' . $request->school_room_id . ', school_room_id accept only integer');
            }
        }
        if (isset($request->teacher_id))
        {
            if (is_numeric($request->teacher_id))
            {
                $lesson->setTeacherId(intval($request->teacher_id));
            }
            else
            {
                throw new InvalidArgumentException('Incorect teacher_id:' . $request->teacher_id . ', teacher_id accept only integer');
            }
        }

        $status = $lesson->create();

        if($status)
        {
            $err = '';
            /** @var \Phalcon\Mvc\Model\MessageInterface $stat */
            foreach ($status as $stat)
            {
                $err = $err . ' ' . $stat->getMessage();
            }
            $binder->SetResponseError(400,
                'Bad Request',
                'The server cannot or will not process the request due to something that is perceived to be a client error',
                $err);
            return $binder->Bind();
        }
        else
        {
            $binder->SetStatusCode(201);
            $binder->SetResponseData($lesson);
            return $binder->Bind();
        }

    }
    catch(InvalidArgumentException $ex)
    {
        $binder->SetResponseError(400,
            'Bad Request',
            'The server cannot or will not process the request due to something that is perceived to be a client error',
            $ex->getMessage());
        return $binder->Bind();
    }
    catch(Exception $ex)
    {
        $binder->SetResponseError(500,
            'Server Error',
            'Internal Server Error',
            $ex->getMessage());
        return $binder->Bind();
    }
});

// curl -i -X DELETE http://timetable/api/lessons/1
$app->delete('/lessons/{lesson_id:[0-9]+}', function($lesson_id) use ($app){
    $binder = new ResponseBinder();

    try
    {
        $lesson = Lesson::findById($lesson_id);
        if (!$lesson)
        {
            $binder->SetResponseError(404,
                'NOT FOUND',
                'teacher not found',
                'teacher with id:' . $lesson_id . ' missing in database');
            return $binder->Bind();
        }
        $response = $lesson->delete();

        if ($response === true)
        {
            $binder->SetStatusCode(200);
            $binder->SetResponseData($lesson);
            return $binder->Bind();
        }
        else
        {
            $binder->SetResponseError(500,
                'Server Error',
                'Internal Server Error',
                'Resourse not be deleted');
            return $binder->Bind();
        }
    }
    catch(Exception $ex)
    {
        $binder->SetResponseError(500,
            'Server error',
            'Internal Server Error',
            $ex->getMessage());
        return $binder->Bind();
    }
});

//--------------------------------API LessonDay--------------------------------

$app->get('/lessonDays', function() use ($app){
    // name
    $binder = new ResponseBinder();

    $request = new Request();
    try
    {
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
            $binder->SetStatusCode(200);
        }
        return $binder->Bind();
    }
    catch(Exception $ex)
    {
        $binder->SetResponseError(500,
            'Server error',
            'Internal Server Error',
            $ex->getMessage());
        return $binder->Bind();
    }
});

$app->get('/lessonDays/{lesson_day_id:[0-9]+}', function($lesson_day_id) {

    $binder = new ResponseBinder();
    try
    {
        $lessonDay = LessonDay::findById($lesson_day_id);
        if($lessonDay)
        {
            $binder->SetStatusCode(200);
            $binder->SetResponseData($lessonDay);
        }
        else
        {
            $binder->SetStatusCode(200);
        }
        return $binder->Bind();
    }
    catch(Exception $ex)
    {
        $binder->SetResponseError(500,
            'Server error',
            'Internal Server Error',
            $ex->getMessage());
        return $binder->Bind();
    }
});

// дописать...
// curl -i -X POST -d '{"lesson_week_id":"1", "wday":"1", "name":"Monday", "lesson_max_count":"8"}' http://timetable/api/lessonDays
$app->post('/lessonDays/{lesson_day_id:[0-9]+}', function($lesson_day_id) use ($app){
    $binder = new ResponseBinder();
    $request = $app->request->getJsonRawBody();
    try
    {
        $lessonDay = LessonDay::findById($lesson_day_id);
        if(!$lessonDay)
        {
            $binder->SetResponseError(404,
                'NOT FOUND',
                'Lesson day not found',
                'Lesson day with id:' . $lesson_day_id . 'not exist in database');
            return $binder->Bind();
        }

        if (isset($request->lesson_week_id))
        {
            if (is_numeric($request->lesson_week_id) )
            {
                $lessonDay->setLessonWeekId(intval($request->lesson_week_id));
            }
            else
            {
                throw new InvalidArgumentException('Incorect lesson_week_id:' . $request->lesson_week_id . ' Lesson week id accept only integer');
            }
        }
        if (isset($request->wday))
        {
            if (is_numeric($request->wday))
            {
                $lessonDay->setWeekday(intval($request->wday));
            }
            else
            {
                throw new InvalidArgumentException('Incorect argument wday:' . $request->wday . ' wday accept only integer');
            }
        }
        if (isset($request->name))
        {
            $lessonDay->setName($request->name);
        }
        if (isset($request->lesson_max_count))
        {
            $lessonDay->setLessonMaxCount(intval($request->lesson_max_count));
        }
        $status = $lessonDay->update();

        if ($status === false)
        {
            $binder->SetStatusCode(200);
            $binder->SetResponseData($lessonDay);
            return $binder->Bind();
        }
        else
        {
            $err = '';
            /** @var \Phalcon\Mvc\Model\MessageInterface $stat */
            foreach ($status as $stat) {
                $err = $err . $stat->getMessage();
            }
            //var_dump($err);
            $binder->SetResponseError(400,
                'Bad Request',
                'The server cannot or will not process the request due to something that is perceived to be a client error',
                $err);
            return $binder->Bind();
        }

    }
    catch(InvalidArgumentException $ex)
    {
        $binder->SetResponseError(400,
            'Bad Request',
            'The server cannot or will not process the request due to something that is perceived to be a client error',
            $ex->getMessage());
        return $binder->Bind();
    }
    catch(Exception $ex)
    {
        $binder->SetResponseError(500,
            'Server error',
            'Internal Server Error',
            $ex->getMessage());
        return $binder->Bind();
    }

});

// дописать...

$app->put('/lessonDays', function() use ($app){
    $request = $app->request->getJsonRawBody();
    $binder = new ResponseBinder();
    try
    {
        /**
         * @var $lessonDay LessonDay
         */
        $lessonDay = new LessonDay();

        if (isset($request->lesson_week_id))
        {
            if (is_numeric($request->lesson_week_id) )
            {
                $lessonDay->setLessonWeekId(intval($request->lesson_week_id));
            }
            else
            {
                throw new InvalidArgumentException('Incorect lesson_week_id:' . $request->lesson_week_id . ' Lesson week id accept only integer');
            }
        }
        if (isset($request->wday))
        {
            if (is_numeric($request->wday))
            {
                $lessonDay->setWeekday(intval($request->wday));
            }
            else
            {
                throw new InvalidArgumentException('Incorect argument wday:' . $request->wday . ' wday accept only integer');
            }
        }
        if (isset($request->name))
        {
            $lessonDay->setName($request->name);
        }
        if (isset($request->lesson_max_count))
        {
            $lessonDay->setLessonMaxCount(intval($request->lesson_max_count));
        }
        $status = $lessonDay->create();

        if ($status === false)
        {
            $binder->SetStatusCode(200);
            $binder->SetResponseData($lessonDay);
            return $binder->Bind();
        }
        else
        {
            $err = '';
            /** @var \Phalcon\Mvc\Model\MessageInterface $stat */
            foreach ($status as $stat) {
                $err = $err . $stat->getMessage();
            }
            //var_dump($err);
            $binder->SetResponseError(400,
                'Bad Request',
                'The server cannot or will not process the request due to something that is perceived to be a client error',
                $err);
            return $binder->Bind();
        }

    }
    catch(InvalidArgumentException $ex)
    {
        $binder->SetResponseError(400,
            'Bad Request',
            'The server cannot or will not process the request due to something that is perceived to be a client error',
            $ex->getMessage());
        return $binder->Bind();
    }
    catch(Exception $ex)
    {
        $binder->SetResponseError(500,
            'Server error',
            'Internal Server Error',
            $ex->getMessage());
        return $binder->Bind();
    }
});

$app->delete('/lessonDays/{lesson_day_id:[0-9]+}', function($lesson_day_id) use ($app)
{
    $binder = new ResponseBinder();

    try
    {
        $lessonDay = LessonDay::findById($lesson_day_id);
        if($lessonDay)
        {
            $status = $lessonDay->delete();
            if($status)
            {
                $binder->SetStatusCode(200);
                $binder->SetResponseData($lessonDay);
                return $binder->Bind();
            }
            else
            {
                $binder->SetResponseError(500,
                    'Server Error',
                    'Internal Server Error',
                    'Resourse not be deleted');
                return $binder->Bind();
            }
        }
        else
        {
            $binder->SetResponseError(404, 'NOT EXIST', 'Lesson Day not exist', 'Lesson Day with id:' . $lesson_day_id . ' not exist');
            return $binder->Bind();
        }
    }
    catch(Exception $ex)
    {
        $binder->SetResponseError(500,
            'Server error',
            'Internal Server Error',
            $ex->getMessage());
        return $binder->Bind();
    }
});


//--------------------------------API LessonWeek--------------------------------

$app->get('/lessonWeeks', function() use ($app)
{
    /** @var stdClass $foo */
    $request = new Request();
    $binder = new ResponseBinder();
    try
    {
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
        if(isset($parameters))
        {
            $lessonWeeks = LessonWeek::getMany($parameters);
            if(!$lessonWeeks)
            {
                $binder->SetStatusCode(200);
                return $binder->Bind();
            }
        }
        else
        {
            $lessonWeeks = LessonWeek::getMany(null);
        }

        if($lessonWeeks)
        {
            $binder->SetStatusCode(200);
            $binder->SetResponseData($lessonWeeks);
            return $binder->Bind();
        }
        else
        {
            $binder->SetStatusCode(200);
            return $binder->Bind();

        }
    }
    catch(Exception $ex)
    {
        $binder->SetResponseError(500,
            'Server error',
            'Internal Server Error',
            $ex->getMessage());
        return $binder->Bind();
    }
});

$app->get('/lessonWeeks/{lesson_week_id:[0-9]+}', function($lesson_week_id){
    $binder = new ResponseBinder();

    try
    {
        $lessonWeek = LessonWeek::findById($lesson_week_id);

        if ($lessonWeek)
        {
            $binder->SetStatusCode(200);
            $binder->SetResponseData($lessonWeek);
            return $binder->Bind();
        }
        else
        {
            $binder->SetStatusCode(200);
            return $binder->Bind();
        }
    }
    catch(Exception $ex)
    {
        $binder->SetResponseError(500,
            'Server error',
            'Internal Server Error',
            $ex->getMessage());
        return $binder->Bind();
    }
});

// curl -i -X PUT -d '{"number":"1", "name":"first week"}' http://timetable/api/lessonWeeks/1
$app->put('/lessonWeeks', function() use ($app){
    $binder = new ResponseBinder();
    $request = $app->request->getJsonRawBody();

    try
    {
        $lessonWeek = new LessonWeek();
        if (isset($request->name))
        {
            $lessonWeek->setName($request->name);
        }
        if (isset($request->number))
        {
            $lessonWeek->setNumber($request->number * 1);
        }
        $status = $lessonWeek->create() ;

        if ($status === false)
        {
            $binder->SetStatusCode(200);
            $binder->SetResponseData($lessonWeek);
            return $binder->Bind();
        }
        else
        {
            $err = '';
            /** @var \Phalcon\Mvc\Model\MessageInterface $stat */
            foreach ($status as $stat) {
                $err = $err . $stat->getMessage();
            }
            //var_dump($err);
            $binder->SetResponseError(400,
                'Bad Request',
                'The server cannot or will not process the request due to something that is perceived to be a client error',
                $err);
            return $binder->Bind();
        }
    }
    catch(Exception $ex)
    {
        $binder->SetResponseError(500,
            'Server error',
            'Internal Server Error',
            $ex->getMessage());
        return $binder->Bind();
    }
});

// curl -i -X POST -d '{"number":"2", "name":"second week"}' http://timetable/api/lessonWeeks
$app->post('/lessonWeeks/{lesson_week_id:[0-9]+}', function($lesson_week_id) use ($app){
    $binder = new ResponseBinder();

    $request = $app->request->getJsonRawBody();
    try
    {
        /** @var LessonWeek $lessonWeek */
        $lessonWeek = LessonWeek::findById($lesson_week_id);
        if ($lessonWeek)
        {
            if (isset($request->name))
            {
                $lessonWeek->setName($request->name);
            }
            if (isset($request->number))
            {
                if(is_numeric($request->number))
                {
                    $lessonWeek->setNumber(intval($request->number));
                }
                else
                {
                    $binder->SetResponseError(400,
                        'Bad Request',
                        'Bad parameter number   ',
                        'number:' . $request->number . '. number must be integer');
                    return $binder->Bind();
                }
            }
            $status = $lessonWeek->save();
            if ($status === false)
            {
                $binder->SetStatusCode(200);
                $binder->SetResponseData($lessonWeek);
                return $binder->Bind();
            }
            else
            {
                $err = '';
                /** @var \Phalcon\Mvc\Model\MessageInterface $stat */
                foreach ($status as $stat) {
                    $err = $err . $stat->getMessage();
                }
                //var_dump($err);
                $binder->SetResponseError(400,
                    'Bad Request',
                    'The server cannot or will not process the request due to something that is perceived to be a client error',
                    $err);
                return $binder->Bind();
            }
        }
        else
        {
            $binder->SetResponseError(404, 'NOT FOUND', 'Lesson Week not found', 'Lesson Week with id:' . $lesson_week_id . ' not exist');
            return $binder->Bind();
        }
    }
    catch(Exception $ex)
    {
        $binder->SetResponseError(500,
            'Server error',
            'Internal Server Error',
            $ex->getMessage());
        return $binder->Bind();
    }
});

// curl -i -X DELETE http://timetable/api/LessonWeeks/1
$app->delete('/lessonWeeks/{lesson_week_id:[0-9]+}', function($lesson_week_id) use ($app){
    $binder = new ResponseBinder();
    /** @var LessonWeek $lessonWeek */
    try
    {
        /** @var LessonWeek $lessonWeek */
        $lessonWeek = LessonWeek::findById($lesson_week_id);

        if($lessonWeek)
        {
            $status = $lessonWeek->delete();

            if($status)
            {
                $binder->SetStatusCode(200);
                $binder->SetResponseData($lessonWeek);
                return $binder->Bind();
            }
            else
            {
                $binder->SetResponseError(500,
                    'Server Error',
                    'Internal Server Error',
                    'Lesson Week not delete');
                return $binder->Bind();
            }
        }
        else
        {
            $binder->SetResponseError(404, 'NOT FOUND', 'Lesson Week not found', 'Lesson Week with id:' . $lesson_week_id . ' not exist ');
            return $binder->Bind();
        }
    }
    catch(Exception $ex)
    {
        $binder->SetResponseError(500,
            'Server error',
            'Internal Server Error',
            $ex->getMessage());
        return $binder->Bind();
    }
});

//----------------------------API Subject------------------------------------------------


$app->post('/subjects/{subject_id:[0-9]+}', function ($subject_id) use ($app)
{
    /** @var stdClass $foo */
    $request = $app->request->getJsonRawBody();
    $binder = new ResponseBinder();
    try
    {
        /** @var Subject $subject*/
        $subject = Subject::findById($subject_id);
        if (!$subject)
        {
            $binder->SetResponseError(404,
                'NOT FOUND',
                'Subject not found',
                'Subject with id:' . $subject_id . ' not found in database');

        }
        if(isset($request->name))
        {
            $subject->setName($request->name);
        }

        $status = $subject->update();

        if($status === false)
        {
            $binder->SetStatusCode(200);
            $binder->SetResponseData($subject);
            return $binder->Bind();
        }
        else
        {
            $err = '';
            /** @var \Phalcon\Mvc\Model\MessageInterface $stat */
            foreach ($status as $stat) {
                $err = $err . $stat->getMessage();
            }
            //var_dump($err);
            $binder->SetResponseError(400,
                'Bad Request',
                'The server cannot or will not process the request due to something that is perceived to be a client error',
                $err);
            return $binder->Bind();
        }
    }
    catch(Exception $ex)
    {
        $binder->SetResponseError(500,
            'Server error',
            'Internal Server Error',
            $ex->getMessage());
        return $binder->Bind();
    }
});
$app->put('/subjects', function () use ($app)
{
    /** @var stdClass $foo */
    $request = $app->request->getJsonRawBody();
    $binder = new ResponseBinder();
    try
    {
        /** @var Subject $subject*/
        $subject = new Subject();
        if (isset($request->name))
        {
            $subject->setName($request->name);
        }
        $status= $subject->create();
        if($status === false)
        {
            $binder->SetStatusCode(201);
            $binder->SetResponseData($subject);
            return $binder->Bind();
        }
        else
        {
            $err = '';
            /** @var \Phalcon\Mvc\Model\MessageInterface $stat */
            foreach ($status as $stat) {
                $err = $err . $stat->getMessage();
            }
            //var_dump($err);
            $binder->SetResponseError(400,
                'Bad Request',
                'The server cannot or will not process the request due to something that is perceived to be a client error',
                $err);
            return $binder->Bind();
        }
    }
    catch(Exception $ex)
    {
        $binder->SetResponseError(500,
            'Server error',
            'Internal Server Error',
            $ex->getMessage());
        return $binder->Bind();
    }
});
$app->delete('/subjects/{id:[0-9]+}', function($subject_id) use($app)
{
    $binder = new ResponseBinder();
    try
    {
        /** @var Subject $subject */
        $subject= Subject::findById($subject_id);
        if (!$subject)
        {
            $binder->SetResponseError(404,
                'NOT FOUND',
                'Subject id not found',
                'Subject_id:' . $subject_id . ' not found in data base');
            return $binder->Bind();
        }
        $status = $subject->delete();
        if($status)
        {
            $binder->SetStatusCode(200);
            $binder->SetResponseData($subject);
            return $binder->Bind();
        }
        else
        {
            $binder->SetResponseError(500,
                'Server Error',
                'Internal Server Error',
                'Subject not be deleted'
            );
            return $binder->Bind();
        }
    }
    catch(Exception $ex)
    {
        $binder->SetResponseError(500,
            'Server error',
            'Internal Server Error',
            $ex->getMessage());
        return $binder->Bind();
    }
});
$app->get('/subjects', function() use ($app)
{
    /** @var Request $request */
    $request = new Request();
    $binder = new ResponseBinder();
    try
    {
        if($request->has('name'))
        {
            $subjects = Subject::findByName($request->get('name'));
            if(!$subjects)
            {
                $binder->SetStatusCode(200);
                return $binder->Bind();
            }
        }
        else
        {
            $subjects = Subject::find();
        }
        if($subjects)
        {
            $binder->SetStatusCode(200);
            $binder->SetResponseData($subjects);
            return $binder->Bind();
        }
        else
        {
            $binder->SetStatusCode(200);
            return $binder->Bind();
        }
    }
    catch(Exception $ex)
    {
        $binder->SetResponseError(500,
            'Server error',
            'Internal Server Error',
            $ex->getMessage());
        return $binder->Bind();
    }
});
/**Get Subject by id*/
$app->get('/subjects/{subject_id:[0-9]+}', function($subject_id)
{
    $binder = new ResponseBinder();
    try
    {
        /** @var Subject $subject */
        $subject = Subject::findById($subject_id);
        if ($subject)
        {
            $binder->SetStatusCode(200);
            $binder->SetResponseData($subject);
            return $binder->Bind();
        }
        else
        {
            $binder->SetStatusCode(200);
            return $binder->Bind();
        }
    }
    catch(Exception $ex)
    {
        $binder->SetResponseError(500,
            'Server error',
            'Internal Server Error',
            $ex->getMessage());
        return $binder->Bind();
    }
});

//----------------------------API SchoolRoom------------------------------------------------
$app->post('/school_rooms/{school_room_id:[0-9]+}', function ($school_room_id) use ($app)
{
    /** @var stdClass $foo */
    $request = $app->request->getJsonRawBody();
    $binder = new ResponseBinder();
    try
    {
        /** @var SchoolRoom $school_room*/
        $school_room = SchoolRoom::findById($school_room_id);
        if(!$school_room)
        {
            $binder->SetResponseError(404,
                'NOT FOUND',
                'School room id not found',
                'School_room_id:' . $school_room_id . ' not found in database' );
        }
        if (isset($request->name))
        {
            $school_room->setName($request->name);
        }

        $status = $school_room->save();

        if($status === false)
        {
            $binder->SetStatusCode(201);
            $binder->SetResponseData($school_room);
            return $binder->Bind();
        }
        else
        {
            $err = '';
            /** @var \Phalcon\Mvc\Model\MessageInterface $stat */
            foreach ($status as $stat) {
                $err = $err . $stat->getMessage();
            }
            //var_dump($err);
            $binder->SetResponseError(400,
                'Bad Request',
                'The server cannot or will not process the request due to something that is perceived to be a client error',
                $err);
            return $binder->Bind();
        }
    }
    catch(Exception $ex)
    {
        $binder->SetResponseError(500,
            'Server error',
            'Internal Server Error',
            $ex->getMessage());
        return $binder->Bind();
    }
});
$app->put('/school_rooms', function () use ($app)
{
    $binder = new ResponseBinder();
    $request = $app->request->getJsonRawBody();
    try
    {
        /** @var SchoolRoom $school_room*/
        $school_room = new SchoolRoom();
        if (isset($request->name))
        {
            $school_room->setName($request->name);
        }
        $status = $school_room->save();
        if($status === false)
        {
            $binder->SetStatusCode(201);
            $binder->SetResponseData($school_room);
            return $binder->Bind();
        }
        else
        {
            $err = '';
            /** @var \Phalcon\Mvc\Model\MessageInterface $stat */
            foreach ($status as $stat) {
                $err = $err . $stat->getMessage();
            }
            //var_dump($err);
            $binder->SetResponseError(400,
                'Bad Request',
                'The server cannot or will not process the request due to something that is perceived to be a client error',
                $err);
            return $binder->Bind();
        }
    }
    catch(Exception $ex)
    {
        $binder->SetResponseError(500,
            'Server error',
            'Internal Server Error',
            $ex->getMessage());
        return $binder->Bind();
    }
});
$app->delete('/school_rooms/{school_room_id:[0-9]+}', function($school_room_id) use($app)
{
    $binder = new ResponseBinder();
    try
    {
        /** @var SchoolRoom $school_room */
        $school_room = SchoolRoom::findById($school_room_id);
        if (!$school_room)
        {
            $binder->SetResponseError(404,
                'NOT FOUND',
                'School room not found',
                'School room wiht id:' . $school_room_id . ' not found');
            return $binder->Bind();
        }
        $status = $school_room->delete();
        if($status)
        {
            $binder->SetStatusCode(200);
            $binder->SetResponseData($school_room);
            return $binder->Bind();
        }
        else
        {
            $binder->SetResponseError(500,
                'Server Error',
                'Internal Server Error',
                'Subject not be deleted'
            );
            return $binder->Bind();
        }
    }
    catch(Exception $ex)
    {
        $binder->SetResponseError(500,
            'Server error',
            'Internal Server Error',
            $ex->getMessage());
        return $binder->Bind();
    }
});
$app->get('/school_rooms', function() use ($app)
{
    /** @var Request $request */
    $request = new Request();
    $binder = new ResponseBinder();
    try
    {
        if($request->has('name'))
        {
            $school_rooms = SchoolRoom::findByName($request->get('name'));
            if(!$school_rooms)
            {
                $binder->SetStatusCode(200);
                return $binder->Bind();
            }
        }
        else
        {
            $school_rooms = SchoolRoom::find();
        }
        if($school_rooms)
        {
            $binder->SetStatusCode(200);
            $binder->SetResponseData($school_rooms);
            return $binder->Bind();
        }
        else
        {
            $binder->SetStatusCode(200);
            return $binder->Bind();
        }
    }
    catch(Exception $ex)
    {
        $binder->SetResponseError(500,
            'Server error',
            'Internal Server Error',
            $ex->getMessage());
        return $binder->Bind();
    }
});
/**Get SchoolRoom by id*/
$app->get('/school_rooms/{school_room_id}', function($school_room_id)
{
    $binder = new ResponseBinder();
    try
    {
        $school_room = SchoolRoom::findById($school_room_id);
        if ($school_room)
        {
            $binder->SetStatusCode(200);
            $binder->SetResponseData($school_room);
            return $binder->Bind();
        }
        else
        {
            $binder->SetStatusCode(200);
            return $binder->Bind();
        }
    }
    catch(Exception $ex)
    {
        $binder->SetResponseError(500,
            'Server error',
            'Internal Server Error',
            $ex->getMessage());
        return $binder->Bind();
    }
});
//----------------------------API SchoolClass------------------------------------------------
$app->post('/school_classes/{school_classes_id}', function ($school_classes_id) use ($app)
{
    /** @var stdClass $foo */
    $request = $app->request->getJsonRawBody();
    $binder = new ResponseBinder();
    try
    {
        /** @var SchoolClass $school_class*/
        $school_class = SchoolClass::findById($school_classes_id);
        if (!$school_class)
        {
            $binder->SetResponseError(404,
                'NOT FOUND',
                'school class not found',
                'school class with id:' . $school_classes_id . ' missing in database');
            return $binder->Bind();
        }
        if (isset($request->name))
        {
            $school_class->setName($request->name);
        }

        $status = $school_class->save();

        if($status === false)
        {
            $binder->SetStatusCode(200);
            $binder->SetResponseData($school_class);
            return $binder->Bind();
        }
        else
        {
            $err = '';
            /** @var \Phalcon\Mvc\Model\MessageInterface $stat */
            foreach ($status as $stat) {
                $err = $err . $stat->getMessage();
            }
            //var_dump($err);
            $binder->SetResponseError(400,
                'Bad Request',
                'The server cannot or will not process the request due to something that is perceived to be a client error',
                $err);
            return $binder->Bind();
        }
    }
    catch(Exception $ex)
    {
        $binder->SetResponseError(500,
            'Server error',
            'Internal Server Error',
            $ex->getMessage());
        return $binder->Bind();
    }
});
$app->put('/school_classes', function () use ($app)
{
    /** @var stdClass $foo */
    $binder = new ResponseBinder();
    $request = $app->request->getJsonRawBody();
    try
    {
        /** @var SchoolClass $school_class*/
        $school_class = new SchoolClass();
        if (isset($request->name))
        {
            $school_class->setName($request->name);
        }
        $status = $school_class->save();
        if($status === false)
        {
            $binder->SetStatusCode(201);
            $binder->SetResponseData($school_class);
            return $binder->Bind();
        }
        else
        {
            $err = '';
            /** @var \Phalcon\Mvc\Model\MessageInterface $stat */
            foreach ($status as $stat) {
                $err = $err . $stat->getMessage();
            }
            //var_dump($err);
            $binder->SetResponseError(400,
                'Bad Request',
                'The server cannot or will not process the request due to something that is perceived to be a client error',
                $err);
            return $binder->Bind();
        }
    }
    catch(Exception $ex)
    {
        $binder->SetResponseError(500,
            'Server error',
            'Internal Server Error',
            $ex->getMessage());
        return $binder->Bind();
    }
});
$app->delete('/school_classes/{id:[0-9]+}', function($school_class_id) use($app)
{
    $binder = new ResponseBinder();
    try
    {
        /** @var SchoolClass $school_class */
        $school_class = SchoolClass::findById($school_class_id);
        if (!$school_class)
        {
            $binder->SetResponseError(404,
                'NOT FOUND',
                'school class not found',
                'school class with id:' . $school_class_id . ' missing in database');
            return $binder->Bind();
        }
        $status = $school_class->delete();
        if($status)
        {
            $binder->SetStatusCode(200);
            $binder->SetResponseData($school_class);
            return $binder->Bind();
        }
        else
        {
            $binder->SetResponseError(500,
                'Server Error',
                'Internal Server Error',
                'Subject cannot be deleted'
            );
            return $binder->Bind();
        }
    }
    catch(Exception $ex)
    {
        $binder->SetResponseError(500,
            'Server error',
            'Internal Server Error',
            $ex->getMessage());
        return $binder->Bind();
    }
});
$app->get('/school_classes', function() use ($app)
{
    /** @var Request $request */
    $request = new Request();
    $binder = new ResponseBinder();
    try
    {
        if($request->has('name'))
        {
            /** @var SchoolClass $school_classes */
            $school_classes = SchoolClass::findByName($request->get('name'));
            if (!$school_classes)
            {
                $binder->SetStatusCode(200);
                $binder->SetResponseData([]);
                return $binder->Bind();
            }
        }
        else
        {
            /** @var SchoolClass $school_classes */
            $school_classes = SchoolClass::find();
        }
        if($school_classes)
        {
            $binder->SetStatusCode(200);
            $binder->SetResponseData($school_classes);
            return $binder->Bind();
        }
        else
        {
            $binder->SetStatusCode(404);
            $binder->SetStatusCode(200);
            return $binder->Bind();
        }
    }
    catch(Exception $ex)
    {
        $binder->SetResponseError(500,
            'Server error',
            'Internal Server Error',
            $ex->getMessage());
        return $binder->Bind();
    }
});
/**Get SchoolClass by id*/
$app->get('/school_classes/{school_class_id:[0-9]+}', function($school_class_id) {
    $binder = new ResponseBinder();
    try
    {
        $school_class = SchoolClass::findById($school_class_id);
        if ($school_class)
        {
            $binder->SetStatusCode(200);
            $binder->SetResponseData($school_class);
            return $binder->Bind();
        }
        else
        {
            $binder->SetStatusCode(200);
            return $binder->Bind();
        }
    }
    catch(Exception $ex)
    {
        $binder->SetResponseError(500,
            'Server error',
            'Internal Server Error',
            $ex->getMessage());
        return $binder->Bind();
    }
});

class ResponseBinder
{
    /** @var Response $response */
    private $response;
    /** @var array $data */
    public $data;
    private $relationships;
    private $responseError;
    ///private $serverErrors;
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
                //'relationships' => $this->relationships,
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
        elseif($statusCode == '500 Internal Server Error')
        {
            $this->response->setJsonContent($this->responseError);
        }
        else
        {
            $this->response->setJsonContent($this->responseError);
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
            /** @var Lesson|Teacher|Subject|LessonWeek|LessonDay|SchoolRoom|SchoolClass $item */
            foreach($dataObject as $item)
            {
                $data[] = $item->GetResponseData();
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
