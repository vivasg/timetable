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
/**
 * change Teacher(first,middle and last name) in db by id
 */
$app->post('/teachers/{teacher_id}', function ($teacher_id) use ($app)
{
    /** @var stdClass $foo */
    $foo = $app->request->getJsonRawBody();

    $binder = new ResponseBinder();

    try
    {
        /**try to find teacher id in db*/
        $teacher = Teacher::findById($teacher_id);
        /**if id not found throw exception*/
        if ($teacher == false)
        {
            throw new Exception('Id not found');
        }
        /**Set incoming data and update data in db*/
        $teacher->setNameFirst($foo->name_first);
        $teacher->setNameLast($foo->name_last);
        $teacher->setNameMiddle($foo->name_middle);
        $status = $teacher->update();
        /**check if update gone successful and set response */
        if($status)
        {
            $binder->SetStatusCode(201);
            $binder->SetResponseData($teacher);
            return $binder->Bind();
        }
        /**if data do not update set error response*/
        else
        {
            $binder->SetStatusCode(501);
            $binder->SetResponseError(501,
                'Conflict',
                'Teacher can`t be saved .',
                'Teacher cannot be saved'
            );
            return $binder->Bind();
        }
    }
    /**if something gone wrong throw Exception*/
    catch (Exception $e)
    {
        echo 'error ', $e->getMessage();

    }

});

$app->put('/teachers', function () use ($app)
{
    /** @var stdClass $foo */
    $foo = $app->request->getJsonRawBody();

    $binder = new ResponseBinder();
    try
    {
        /** @var Teacher $teacher*/
        $teacher = new Teacher(new \Dto\Teacher());
        /** set teacher data and save data in db*/
        $teacher->setNameFirst($foo->name_first);
        $teacher->setNameLast($foo->name_last);
        $teacher->setNameMiddle($foo->name_middle);
        $status = $teacher->save();
        /**if save gone successful set response*/
        if($status)
        {
            $binder->SetStatusCode(201,'Created');
            $binder->SetResponseData($teacher);
            return $binder->Bind();
        }
        /**if data cant be save set error response*/
        else
        {
            $binder->SetStatusCode(501,'Conflict');
            $binder->SetResponseError(501,
                'Conflict',
                'Teacher can`t be saved .',
                'Teacher cannot be saved'
            );
            return $binder->Bind();
        }

    }
    catch (Exception $e)
    {
        echo $e->getMessage();
    }






});

$app->delete('/teachers/{teacher_id}', function($teacher_id) use($app)
{
    $binder = new ResponseBinder();

    try
    {
        $teacher = Teacher::findById($teacher_id);
        if ($teacher == false)
        {
            throw new Exception('Id:' . $teacher_id . ' not found');
        }
        $status = $teacher->delete();
        if($status)
        {
            $binder->SetStatusCode(200);
            $binder->SetResponseData($teacher);
        }
        else
        {
            $binder->SetStatusCode(501);
            $binder->SetResponseError(501,
                'Conflict',
                'Teacher cannot be deleted',
                'Teacher cannot be deleted'
            );
        }

    }
    catch (Exception $e)
    {
        echo 'Error ', $e->getMessage();
    }



});

$app->get('/teachers', function() use ($app)
{
    /** @var Request $request */
    $request = new Request();
    try
    {
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
    }
    catch(Exception $e)
    {
        echo $e->getMessage();
    }


	return $response;
});

/**Get Teacher by id*/
$app->get('/teachers/{teacher_id}', function($teacher_id)
{
    $binder = new ResponseBinder();

	try
    {
        $teacher = Teacher::findById($teacher_id);
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
    }
    catch(Exception $e)
    {
        echo $e->getMessage();
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
            throw new Exception('id not found');
        }
        var_dump($foo->name);
        $subject->setName($foo->name);
        $status = $subject->update();


        if($status)
        {
            $binder->SetStatusCode(201);
            $binder->SetResponseData($subject);
            return $binder->Bind();

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
    $binder = new ResponseBinder();

    try
    {
        /** @var Subject $subject*/
        $subject = new Subject(new \Dto\Subject());
        $subject->setName($foo->name);
        $status= $subject->save();
        if($status)
        {
            $binder->SetStatusCode(201);
            $binder->SetResponseData($subject);
            return $binder->Bind();

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
    }
    catch(Exception $e)
    {
        echo $e->getMessage();
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
            $binder->SetResponseData($subject);
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
    try
    {
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

            $binder->SetResponseData($subjects);
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
    }
    catch(Exception $e)
    {
        echo $e->getMessage();
    }


    return $response;
});

/**Get Subject by id*/
$app->get('/subjects/{subject_id}', function($subject_id)
{

    $binder = new ResponseBinder();

    try
    {
        $subject = Subject::findById($subject_id);
        if ($subject)
        {
            $binder->SetResponseData($subject);
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
    }
    catch(Exception $e)
    {
        echo $e->getMessage();
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
            $binder->SetResponseData($school_room);

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

    try
    {
        /** @var SchoolRoom $school_room*/
        $school_room = new SchoolRoom(new \Dto\SchoolRoom());
        $school_room->setName($foo->name);
        $status = $school_room->save();

        $binder = new ResponseBinder();

        if($status)
        {
            $binder->SetStatusCode(201, 'Created');
            $binder->SetResponseData($school_room);

        }
        else
        {
            $binder->SetStatusCode(409, '409');
            $binder->SetResponseError(409,
                'Conflict',
                'Can`t be saved .',
                'SchoolRoom with name cannot be saved'
            );
        }

    }
    catch(Exception $e)
    {
        echo $e->getMessage();
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
            $binder->SetResponseData($school_room);
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
    try
    {
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

            $binder->SetResponseData($school_rooms);
            return $binder->Bind();
        }
        else
        {
            $binder->SetStatusCode(404);
            $binder->SetResponseError(404,
                'NOT FOUND',
                'school_room not found',
                'school_room with name \''. $request->get('name') . '\' missing in database');
            return $binder->Bind();
        }
    }
    catch(Exception $e)
    {
        echo $e->getMessage();
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
            $binder->SetResponseData($school_room);
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
    }
    catch(Exception $e)
    {
        echo $e->getMessage();
    }

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
        $school_class = SchoolClass::findById($school_classes_id);
        if ($school_class == false)
        {
            throw new Exception;
        }
        $school_class->setName($foo->name);
        $status = $school_class->save();


        if($status)
        {
            $binder->SetStatusCode(200);
            $binder->SetResponseData($school_class);

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

    try
    {
        /** @var SchoolClass $school_class*/
        $school_class = new SchoolRoom(new \Dto\SchoolRoom());
        $school_class->setName($foo->name);
        $status = $school_class->save();

        $binder = new ResponseBinder();

        if($status)
        {
            $binder->SetStatusCode(201);
            $binder->SetResponseData($school_class);

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
    catch(Exception $e)
    {
        echo $e->getMessage();
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
            $binder->SetResponseData($school_class);
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
    try
    {
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

            $binder->SetResponseData($school_classes);
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
    }
    catch(Exception $e)
    {
        echo $e->getMessage();
    }


    return $response;
});

/**Get SchoolClass by id*/
$app->get('/school_classes/{school_class_id}', function($school_class_id)
{
    $binder = new ResponseBinder();


    try
    {
        $school_class = SchoolClass::findById($school_class_id);
        if ($school_class)
        {
            $binder->SetResponseData($school_class);
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
    }
    catch(Exception $e)
    {
        echo $e->getMessage();
    }


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
        if($statusCode == 200) {
            $this->response->setJsonContent([
                'links' => [
                    'self' => $app->url->path($app->request->getURI()),
                ],
                'data' => $this->data,
                'relationships' => $this->relationships,
                'meta' => $this->GetMeta(),
            ]);
        }
        if($statusCode == 201) {
            $this->response->setJsonContent([
                'links' => [
                    'self' => $app->url->path($app->request->getURI()),
                ],
                'data' => 'created',
                'relationships' => $this->relationships,
                'meta' => $this->GetMeta(),
            ]);
        }
        if($statusCode == 404)
        {
            $this->response->setJsonContent($this->responseError);
        }
        if($statusCode == 209)
        {
            $this->response->setJsonContent($this->responseError);
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
            $data = $dataObject->GetResponseData();
        }
        $this->data = $data;
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