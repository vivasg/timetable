<?php

namespace Dto;

use \Phalcon\Mvc\Model,
    Phalcon\Mvc\Model\Validator\PresenceOf;

class Lesson extends Model
{
    /**
     * @var int
     */
    private $id;
    /**
     * @var LessonDay
     */
    private $lessonDay;
    /**
     * @var int
     */
    private $lessonDayId;
    /**
     * @var int
     */
    private $lessonNumber;
    /**
     * @var SchoolClass
     */
    private $schoolClass;
    /**
     * @var int
     */
    private $schoolClassId;
    /**
     * @var Subject
     */
    private $subject;
    /**
     * @var int
     */
    private $subjectId;
    /**
     * @var SchoolRoom
     */
    private $schoolRoom;
    /**
     * @var int
     */
    private $schoolRoomId;
    /**
     * @var Teacher
     */
    private $teacher;
    /**
     * @var int
     */
    private $teacherId;

    /**
     * @return int
     */
    public function getId()
    {
        if(is_null($this->id))
        {

        }
        return $this->id;
    }

    /**
     * @param $id
     *
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return LessonDay|null
     */
    public function getLessonDay()
    {
        return $this->lessonDay;
    }

    /**
     * @param $lessonDay|null
     *
     * @return $this
     */
    public function setLessonDay($lessonDay)
    {
        $this->lessonDay = $lessonDay;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getLessonDayId()
    {
        return $this->lessonDayId;
    }

    /**
     * @param $lessonDayId|null
     * @return $this
     */
    public function setLessonDayId($lessonDayId)
    {
        $this->lessonDayId = $lessonDayId;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getLessonNumber()
    {
        return $this->lessonNumber;
    }

    /**
     * @param $lessonNumber
     * @return $this
     */
    public function setLessonNumber($lessonNumber)
    {
        $this->lessonNumber = $lessonNumber;
        return $this;
    }

    /**
     * @return SchoolClass
     */
    public function getSchoolClass()
    {
        if(is_null($this->schoolClass))
        {
        }
        return $this->schoolClass;
    }

    /**
     * @param $schoolClass
     * @return $this
     */
    public function setSchoolClass($schoolClass)
    {
        $this->schoolClass = $schoolClass;
        return $this;
    }

    /**
     * @return int
     */
    public function getSchoolClassId()
    {
        return $this->schoolClassId;
    }

    /**
     * @param $schoolClassId
     * @return $this
     */
    public function setSchoolClassId($schoolClassId)
    {
        $this->schoolClassId = $schoolClassId;
        return $this;
    }

    /**
     * @return int
     */
    public function getSubjectId()
    {
        return $this->subjectId;
    }

    /**
     * @return Subject
     */
    public function getSubject()
    {
        return $this->subject;
    }
    /**
     * @param $subject
     * @return $this
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
        return $this;
    }

    /**
     * @return SchoolRoom|null
     */
    public function getSchoolRoom()
    {
        return $this->schoolRoom;
    }

    /**
     * @param $schoolRoom|null
     * @return $this
     */
    public function setSchoolRoom($schoolRoom)
    {
        $this->schoolRoom = $schoolRoom;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getSchoolRoomId()
    {
        return $this->schoolRoomId;
    }

    /**
     * @param $schoolRoomId|
     * @return $this
     */
    public function setSchoolRoomId($schoolRoomId)
    {
        $this->schoolRoomId = $schoolRoomId;
        return $this;
    }

    /**
     * @return Teacher|null
     */
    public function getTeacher()
    {
        return $this->teacher;
    }

    /**
     * @param $teacher|null
     * @return $this
     */
    public function setTeacher($teacher)
    {
        $this->teacher = $teacher;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getTeacherId()
    {
        return $this->teacherId;
    }

    /**
     * @param $teacherId|null
     * @return $this
     */
    public function setTeacherId($teacherId)
    {
        $this->teacherId = $teacherId;
        return $this;
    }

    public function validation()
    {
        //rules for id
        $this->validate(new PresenceOf([
            'field' => 'id',
            'message' => 'Not id in model',
        ]));

        //rules for lessonDay
        $this->validate(new PresenceOf([
            'field' => 'lessonDay',
            'message' => 'Not lessonDay in model',
        ]));

        //rules for lessonDayId
        $this->validate(new PresenceOf([
            'field' => 'lessonDayId',
            'message' => 'Not id in model',
        ]));

        //rules for lessonNumber
        $this->validate(new PresenceOf([
            'field' => 'lessonNumber',
            'message' => 'Not lessonNumber in model',
        ]));

        //rules for lessonNumberId
        $this->validate(new PresenceOf([
            'field' => 'lessonNumberId',
            'message' => 'Not lessonNumberId in model',
        ]));

        //rules for schoolClass
        $this->validate(new PresenceOf([
            'field' => 'schoolClass',
            'message' => 'Not schoolClass in model',
        ]));

        //rules for schoolClassId
        $this->validate(new PresenceOf([
            'field' => 'schoolClassId',
            'message' => 'Not schoolClassId in model',
        ]));

        //rules for subject
        $this->validate(new PresenceOf([
            'field' => 'subject',
            'message' => 'Not subject in model',
        ]));

        //rules for subjectId
        $this->validate(new PresenceOf([
            'field' => 'subjectId',
            'message' => 'Not subjectId in model',
        ]));

        //rules for schoolRoom
        $this->validate(new PresenceOf([
            'field' => 'schoolRoom',
            'message' => 'Not schoolRoom in model',
        ]));

        //rules for schoolRoomId
        $this->validate(new PresenceOf([
            'field' => 'schoolRoomId',
            'message' => 'Not schoolRoomId in model',
        ]));

        //rules for teacher
        $this->validate(new PresenceOf([
            'field' => 'teacher',
            'message' => 'Not teacher in model',
        ]));

        //rules for teacherId
        $this->validate(new PresenceOf([
            'field' => 'teacherId',
            'message' => 'Not teacherId in model',
        ]));



        if ($this->validationHasFailed() == true)
        {
            return false;
        }
        return true; //what should return this method???
    }
}