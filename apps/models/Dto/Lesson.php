<?php

namespace Dto;

use \Phalcon\Mvc\Model,
    Phalcon\Mvc\Model\Validator\PresenceOf,
    Phalcon\Mvc\Model\Validator\Numericality;

/**
 * Class Lesson
 * @package Dto
 * @property \Dto\LessonDay $day
 * @property \Dto\SchoolClass $class
 * @property \Dto\Subject $subject
 * @property \Dto\SchoolRoom $room
 * @property \Dto\Teacher $teacher
 */
class Lesson extends Model
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $lesson_day_id;
    /**
     * @var int
     */
    private $lesson_number;
    /**
     * @var int
     */
    private $school_class_id;
    /**
     * @var int
     */
    private $subject_id;
    /**
     * @var int
     */
    private $school_room_id;
    /**
     * @var int
     */
    private $teacher_id;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param $id
     *
     * @return $this
     */
    public function setId($id)
    {
        if(!is_int($id) )
        {
            throw new \InvalidArgumentException('parameter "id" can be integer');
        }
        if($id < 0)
        {
            throw new \OutOfRangeException('parameter "id" can not be less than 0');
        }
        $this->id = $id;
        return $this;
    }

    /**
     * @return LessonDay|null
     */
    public function getLessonDay()
    {
        return $this->day == false? null: $this->day;
    }

    /**
     * @param $lessonDay|null
     *
     * @return $this
     */
    public function setLessonDay($lessonDay)
    {
        if(!$lessonDay instanceof LessonDay)
        {
            throw new \InvalidArgumentException('invalid type parameter: "lessonDay"');
        }
        $this->day = $lessonDay;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getlessonDayId()
    {
        return $this->lesson_day_id;
    }

    /**
     * @param $lesson_day_id|null
     * @return $this
     */
    public function setlessonDayId($lesson_day_id)
    {
        if(!(is_int($lesson_day_id) || is_null($lesson_day_id)))
        {
            throw new \InvalidArgumentException('parameter "lesson_day_id" must be integer or null');
        }
        if($lesson_day_id < 0)
        {
            throw new \OutOfRangeException('parameter "lesson_day_id" can not be less than 0');
        }
        $this->lesson_day_id = $lesson_day_id;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getLessonNumber()
    {
        return $this->lesson_number;
    }

    /**
     * @param $lesson_number
     * @return $this
     */
    public function setLessonNumber($lesson_number)
    {
        if(!(is_int($lesson_number) || is_null($lesson_number)))
        {
            throw new \InvalidArgumentException('parameter "lessonNumber" must be integer or null');
        }
        $this->lesson_number = $lesson_number;
        return $this;
    }

    /**
     * @return SchoolClass
     */
    public function getSchoolClass()
    {
        return $this->class;
    }

    /**
     * @param $schoolClass
     * @return $this
     */
    public function setSchoolClass($schoolClass)
    {
        if(is_null($schoolClass))
        {
            throw new \InvalidArgumentException('school class is null');
        }
        if(!$schoolClass instanceof SchoolClass)
        {
            throw new \InvalidArgumentException('invalid type of argument: "schoolClass"');
        }
        $this->class = $schoolClass;
        return $this;
    }

    /**
     * @return int
     */
    public function getSchoolClassId()
    {
        return $this->school_class_id;
    }

    /**
     * @param $school_class_id
     * @return $this
     */
    public function setSchoolClassId($school_class_id)
    {
        if(!is_int($school_class_id))
        {
            throw new \InvalidArgumentException('parameter "schoolClassId" can be integer');
        }
        if($school_class_id < 0)
        {
            throw new \OutOfRangeException('parameter "schoolClassId" can not be less than 0');
        }
        $this->school_class_id = $school_class_id;
        return $this;
    }

    /**
     * @return int
     */
    public function getSubjectId()
    {
        return $this->subject_id;
    }

    public function setSubjectId($subject_id)
    {
        if(!is_int($subject_id))
        {
            throw new \InvalidArgumentException('parameter "subjectId" can be integer');
        }
        if($subject_id < 0)
        {
            throw new \OutOfRangeException('parameter "subjectId" can not be less than 0');
        }
        $this->subject_id = $subject_id;
        return $this;
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
        if(is_null($subject))
        {
            throw new \InvalidArgumentException('parameter "subject" is null');
        }
        if(!$subject instanceof Subject)
        {
            throw new \InvalidArgumentException('invalid type of argument: "subject"');
        }
        $this->subject = $subject;
        return $this;
    }

    /**
     * @return SchoolRoom|null
     */
    public function getSchoolRoom()
    {
        return $this->room;
    }

    /**
     * @param $schoolRoom|null
     * @return $this
     */
    public function setSchoolRoom($schoolRoom)
    {
        if(!$schoolRoom instanceof SchoolRoom)
        {
            throw new \InvalidArgumentException('invalid type of argument: "schoolRoom"');
        }
        $this->room = $schoolRoom;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getSchoolRoomId()
    {
        return $this->school_room_id;
    }

    /**
     * @param $school_room_id|
     * @return $this
     */
    public function setSchoolRoomId($school_room_id)
    {
        if(!(is_int($school_room_id) || is_null($school_room_id)))
        {
            throw new \InvalidArgumentException('parameter "schoolRoomId" must be integer or null');
        }
        if($school_room_id < 0)
        {
            throw new \OutOfRangeException('parameter "schoolRoomId" can not be less than 0');
        }
        $this->school_room_id = $school_room_id;
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

        if($teacher instanceof \Teacher)
        {
            throw new \InvalidArgumentException('invalid type of argument: "teacher"');
        }
        $this->teacher = $teacher;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getTeacherId()
    {
        return $this->teacher_id;
    }

    /**
     * @param $teacher_id|null
     * @return $this
     */
    public function setTeacherId($teacher_id)
    {
        if(!(is_int($teacher_id) || is_null($teacher_id)))
        {
            throw new \InvalidArgumentException('parameter "teacherId" can be integer or null');
        }
        if($teacher_id < 0)
        {
            throw new \OutOfRangeException('parameter "teacherId" can not be less than 0');
        }
        $this->teacher_id = $teacher_id;
        return $this;
    }

    public function initialize()
    {
        $this->setSource('lessons');
        $this->belongsTo('lesson_day_id', 'Dto\LessonDay', 'id', [
            'alias' => 'day',
        ]);
        $this->belongsTo('school_class_id', 'Dto\SchoolClass', 'id', [
            'alias' => 'class',
        ]);
        $this->belongsTo('subject_id', 'Dto\Subject', 'id', [
            'alias' => 'subject',
        ]);
        $this->belongsTo('school_room_id', 'Dto\SchoolRoom', 'id', [
            'alias' => 'room',
        ]);
        $this->belongsTo('teacher_id', 'Dto\Teacher', 'id', [
            'alias' => 'teacher',
        ]);
    }



    public function validation()
    {
        //rules for lessonDay
        /*
        $this->validate(new PresenceOf([
            'field' => 'lessonDay',
            'message' => 'Not lessonDay in model',
        ]));

        //rules for lesson_day_id
        $this->validate(new PresenceOf([
            'field' => 'lesson_day_id',
            'message' => 'Not id in model',
        ]));

        //rules for lessonNumber
        $this->validate(new PresenceOf([
            'field' => 'lessonNumber',
            'message' => 'Not lessonNumber in model',
        ]));*/


        //rules for schoolClassId
        $this->validate(new PresenceOf([
            'field' => 'school_class_id',
            'message' => 'Not school_class_id in model',
        ]));
        $this->validate(new Numericality([
            'field' => 'school_class_id',
            'message' => 'school class id must be id'
        ]));

        //rules for subjectId
        $this->validate(new PresenceOf([
            'field' => 'subject_id',
            'message' => 'Not subjectId in model',
        ]));
        $this->validate(new Numericality([
            'field' => 'subject_id',
            'message' => 'subject id must be id'
        ]));


        /*
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
*/


        if ($this->validationHasFailed() == true)
        {
            return false;
        }
        return true; //what should return this method???
    }
    public function getSource()
    {
        return 'lessons';
    }

}