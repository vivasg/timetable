<?php

use \Dto\Lesson as Dto,
    \Phalcon\Mvc\Model\Resultset\Simple;

class Lesson
{
    /**
     * @var \Dto\Lesson
     */
    private $dto;

    const MAX_LESSON_NUMBER = '13';
    const MIN_LESSON_NUMBER = '0';

    /**
     * Get id
     *
     * @return int
     */
    public function getTeacherId()
    {
        return $this->dto->getTeacherId();
    }

    /**
     * Set Teacher id
     *
     * @param int $teacherId
     * @return $this
     */
    public function setTeacherId($teacherId)
    {
        if(!is_int($teacherId))
        {
            throw new \InvalidArgumentException('parameter "teacherId" can be integer');
        }
        if($teacherId < 0)
        {
            throw new \OutOfRangeException('parameter "teacherId" can not be less than 0');
        }
        $this->dto->setTeacherId($teacherId);
        return $this;
    }

    /**
     * Get School Room id
     *
     * @return int
     */
    public function getSchoolRoomId()
    {
        return $this->dto->getSchoolRoomId();
    }

    /**
     * Set School Room id
     *
     * @param int $schoolRoomId
     * @return $this
     */
    public function setSchoolRoomId($schoolRoomId)
    {
        if(!is_int($schoolRoomId))
        {
            throw new \InvalidArgumentException('parameter "schoolRoomId" can be integer');
        }
        if($schoolRoomId < 0)
        {
            throw new \OutOfRangeException('parameter "schoolRoomId" can not be less than 0');
        }
        $this->dto->setSchoolRoomId($schoolRoomId);
        return $this;
    }

    /**
     * Get Subject id
     *
     * @return int
     */
    public function getSubjectId()
    {
        return $this->dto->getSubjectId();
    }

    /**
     * Set Subject id
     *
     * @param int $subjectId
     * @return $this
     */
    public function setSubjectId($subjectId)
    {
        if(!is_int($subjectId))
        {
            throw new \InvalidArgumentException('parameter "subjectId" can be integer');
        }
        if($subjectId < 0)
        {
            throw new \OutOfRangeException('parameter "subjectId" can not be less than 0');
        }
        $this->dto->setSubject($subjectId);
        return $this;
    }

    /**
     * Get School Class id
     *
     * @return int
     */
    public function getSchoolClassId()
    {
        return $this->dto->getSchoolClassId();
    }

    /**
     * Set School Class id
     *
     * @param int $schoolClassId
     * @return $this
     */
    public function setSchoolClassId($schoolClassId)
    {
        if(!is_int($schoolClassId))
        {
            throw new \InvalidArgumentException('parameter "schoolClassId" can be integer');
        }
        if($schoolClassId < 0)
        {
            throw new \OutOfRangeException('parameter "schoolClassId" can not be less than 0');
        }
        $this->dto->setSchoolClassId($schoolClassId);
        return $this;
    }

    /**
     * Get Lesson Day id
     *
     * @return int
     */
    public function getLessonDayId()
    {
        return $this->dto->getLessonDayId();
    }

    /**
     * Set Lesson Day id
     *
     * @param int $lessonDayId
     * @return $this
     */
    public function setLessonDayId($lessonDayId)
    {
        if(!is_int($lessonDayId))
        {
            throw new \InvalidArgumentException('parameter "lessonDayId" can be integer');
        }
        if($lessonDayId < 0)
        {
            throw new \OutOfRangeException('parameter "lessonDayId" can not be less than 0');
        }
        $this->dto->setLessonDayId($lessonDayId);
        return $this;
    }

    /**
     * Get id by Lesson
     *
     * @return int
     */
    public function getId()
    {
        return $this->dto->getId();
    }

    /**
     * Set id by Lesson
     *
     * @param int $id
     * @return $this
     */
    public function setId($id)
    {
        if(!is_int($id))
        {
            throw new \InvalidArgumentException('parameter "id" can be integer');
        }
        if($id < 0)
        {
            throw new \OutOfRangeException('parameter "id" can not be less than 0');
        }
        $this->dto->setId($id);
        return $this;
    }

    /**
     * Get Lesson Day
     *
     * @return LessonDay
     */
    public function getLessonDay()
    {
        return new \LessonDay($this->dto->getLessonDay());
    }

    /**
     * Set Lesson Day
     *
     * @param LessonDay $lessonDay
     * @return $this
     */
    public function setLessonDay($lessonDay)
    {
        if(is_null($lessonDay))
        {
            throw new \InvalidArgumentException('parameter "lessonDay" is null');
        }
        if(gettype($lessonDay) != 'LessonDay')
        {
            throw new \InvalidArgumentException('invalid type parameter: "lessonDay"');
        }
        $this->dto->setLessonDay($lessonDay);
        return $this;
    }

    /**
     * Get Lesson Number
     *
     * @return int
     */
    public function getLessonNumber()
    {
        return $this->dto->getLessonNumber();
    }

    /**
     * Set Lesson Number
     *
     * @param int $lessonNumber
     * @return $this
     */
    public function setLessonNumber($lessonNumber)
    {
        if(!is_int($lessonNumber))
        {
            throw new \InvalidArgumentException('invalid type argument: "lessonNumber"');
        }
        if($lessonNumber < self::MIN_LESSON_NUMBER || $lessonNumber > self::MAX_LESSON_NUMBER)
        {
            throw new \OutOfRangeException('parameter "lessonNumber" can not be less than' . self::MIN_LESSON_NUMBER . 'ot greater than' . self::MAX_LESSON_NUMBER);
        }
        $this->dto->setLessonNumber($lessonNumber);
        return $this;
    }

    /**
     * Get School Class
     *
     * @return SchoolClass
     */
    public function getSchoolClass()
    {
        return new \SchoolClass($this->dto->getSchoolClass());
    }

    /**
     * Set School Class
     *
     * @param SchoolClass $schoolClass
     * @return $this
     */
    public function setSchoolClass(SchoolClass $schoolClass)
    {
        if(is_null($schoolClass))
        {
            throw new \InvalidArgumentException('parameter "schoolClass" is null');
        }
        if(get_class($schoolClass) != 'SchoolClass')
        {
            throw new \InvalidArgumentException('invalid type of argument: "schoolClass"');
        }
        $this->dto->setSchoolClass($schoolClass);
        return $this;
    }

    /**
     * Get School Room
     *
     * @return SchoolRoom
     */
    public function getSchoolRoom()
    {
        return new \SchoolRoom($this->dto->getSchoolRoom());
    }

    /**
     * Set School Room
     *
     * @param SchoolRoom $schoolRoom
     * @return $this
     */
    public function setSchoolRoom($schoolRoom)
    {
        if(get_class($schoolRoom) != 'SchoolRoom')
        {
            throw new \InvalidArgumentException('invalid type of argument: "schoolRoom"');
        }
        $this->dto->setSchoolRoom($schoolRoom);
        return $this;
    }

    /**
     * Get Subject
     *
     * @return Subject
     */
    public function getSubject()
    {
        return new \Subject($this->dto->getSubject());
    }

    /**
     * Set Subject
     *
     * @param Subject $subject
     * @return $this
     */
    public function setSubject($subject)
    {
        if(is_null($subject))
        {
            throw new \InvalidArgumentException('parameter "subject" is null');
        }
        if(get_class($subject) != 'Subject')
        {
            throw new \InvalidArgumentException('invalid type of argument: "subject"');
        }
        $this->dto->setSubject($subject);
        return $this;
    }

    /**
     * Get Teacher
     *
     * @return Teacher
     */
    public function getTeacher()
    {
        return new \Teacher($this->dto->getTeacher());
    }

    /**
     * Set Teacher
     *
     * @param Teacher $teacher
     * @return $this;
     */
    public function setTeacher($teacher)
    {
        if(get_class($teacher) != 'Teacher')
        {
            throw new \InvalidArgumentException('invalid type of argument: "teacher"');
        }
        $this->dto->setTeacher($teacher);
        return $this;
    }

    public function __construct($dto)
    {
        $this->dto = $dto;
    }

    /**find all Lessons
     * @return array|null
     */
    public static function find()
    {
        return  Lesson::getMany(null);
    }

    /** find Lesson by id
     * @param int $id
     * @return Lesson|null
     */
    public static function findById($id)
    {
        $parameters = [
            'conditions' => 'id=:id:',
            'bind' => [
                'id' => $id
            ],
        ];
        return Lesson::getOne($parameters);
    }

    /**find Lessons by Lesson Day id
     * @param int $lessonDayId
     * @return array|null
     */
    public static function findByLessonDayId($lessonDayId)
    {
            $parameters = [
                'conditions' => 'lesson_day_id=:id:',
                'bind' => [
                    'id' => $lessonDayId
                ],
            ];
            return Lesson::getMany($parameters);
    }

    /**find Lessons by School Room id
     * @param int $schoolRoomId
     * @return array|null
     */
    public static function findBySchoolRoomId($schoolRoomId)
    {
        $parameters = [
            'conditions' => 'lesson_day_id=:id:',
            'bind' => [
                'id' => $schoolRoomId
            ],
        ];
        return Lesson::getMany($parameters);
    }

    /**find by Lessons Subject id
     * @param int $subjectId
     * @return array|null
     */
    public static function findBySubjectId($subjectId)
    {
        $parameters = [
            'conditions' => 'subject_id=:id:',
            'bind' => [
                'id' => $subjectId
            ],
        ];
        return Lesson::getMany($parameters);
    }
    /**find Lessons by Teacher id
     * @param int $teacherId
     * @return Lesson
     */
    public static function findByTeacherId($teacherId)
    {
        $parameters = [
            'conditions' => 'teacher_id=:teacher_id:',
            'bind' => [
                'teacher_id' => $teacherId
            ],
        ];
        return Lesson::getMany($parameters);
    }

    /** Return an array of the selected items
     * @param $parameters
     * @return array|null
     */
    public static function getMany($parameters)
    {
        /** @var Simple $tmp_lesson */
        $tmp_lessons = Dto::find($parameters);
        if ($tmp_lessons instanceof Simple && $tmp_lessons->count() > 0)
        {
            $return = [];

            /** @var Dto $tmp_lesson */
            foreach ($tmp_lessons as $tmp_lesson)
            {
                $return[] = new Lesson($tmp_lesson);
            }

            return $return;
        }
        return null;
    }

    /** Return an element of the selected item
     * @param $parameters
     * @return Lesson|null
     */
    public static function getOne($parameters)
    {
        /** @var Dto $tmp_lesson */
        $tmp_lesson = Dto::findFirst($parameters);
        if ($tmp_lesson instanceof Dto)
        {
            return new Lesson($tmp_lesson);
        }
        return null;
    }

    public function getFullResponseData()
    {
        /** @var Lesson $object */
        $data[] = [
            'type' => 'Lesson',
            'id' => $this->getId(),
            'attributes' => [
                //'lesson_day' => $this->GetLessonWeekDataByObject($object->getLessonDay()), // failed! in database set null.
                'lesson_number' => $this->getLessonNumber(),
                'school_class' => $this->getSchoolClass()->GetResponseData(),
                'subject' => $this->getSubject()->GetResponseData(),
                'school_room' => $this->getSchoolRoom()->GetResponseData(),
                'teacher' => $this->GetTeacher()->GetResponseData(),
            ],
        ];
        return $data;
    }
    public function getShortResponseData()
    {
        /** @var Lesson $object */
        $data[] = [
            'type' => 'Lesson',
            'id' => $this->getId(),
            'attributes' => [
                'lesson_day_id' => $this->getLessonDayId(),
                'lesson_number' => $this->getLessonNumber(),
                'school_class_id' => $this->getSchoolClassId(),
                'subject_id' => $this->getSubjectId(),
                'school_room_id' => $this->getSchoolRoomId(),
                'teacher_id' => $this->getTeacherId()
            ],
        ];
        return $data;
    }
}
