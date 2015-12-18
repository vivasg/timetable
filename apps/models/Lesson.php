<?php
class Lesson
{
    private $id;
    private $lessonDay;
    private $lessonDayId;
    private $lessonNumber;
    private $schoolClass;
    private $schoolClassId;
    private $subject;
    private $subjectId;
    private $schoolRoom;
    private $schoolRoomId;
    private $teacher;
    private $teacherId;
    const MAX_LESSON_NUMBER = '13';
    const MIN_LESSON_NUMBER = '0';

    /**
     * Get id
     *
     * @return int
     */
    public function getTeacherId()
    {
        return $this->teacherId;
    }

    /**
     * Set Teacher id
     *
     * @param int $teacherId
     * @return void
     */
    public function setTeacherId($teacherId)
    {
        if(!is_int($teacherId))
        {
            throw new InvalidArgumentException('parameter "teacherId" can be integer');
        }
        if($teacherId < 0)
        {
            throw new OutOfRangeException('parameter "teacherId" can not be less than 0');
        }
        $this->teacherId = $teacherId;
    }

    /**
     * Get School Room id
     *
     * @return int
     */
    public function getSchoolRoomId()
    {
        return $this->schoolRoomId;
    }

    /**
     * Set School Room id
     *
     * @param int $schoolRoomId
     * @return void
     */
    public function setSchoolRoomId($schoolRoomId)
    {
        if(!is_int($schoolRoomId))
        {
            throw new InvalidArgumentException('parameter "schoolRoomId" can be integer');
        }
        if($schoolRoomId < 0)
        {
            throw new OutOfRangeException('parameter "schoolRoomId" can not be less than 0');
        }
        $this->schoolRoomId = $schoolRoomId;
    }

    /**
     * Get Subject id
     *
     * @return int
     */
    public function getSubjectId()
    {
        return $this->subjectId;
    }

    /**
     * Set Subject id
     *
     * @param int $subjectId
     * @return void
     */
    public function setSubjectId($subjectId)
    {
        if(!is_int($subjectId))
        {
            throw new InvalidArgumentException('parameter "subjectId" can be integer');
        }
        if($subjectId < 0)
        {
            throw new OutOfRangeException('parameter "subjectId" can not be less than 0');
        }
        $this->subjectId = $subjectId;
    }

    /**
     * Get School Class id
     *
     * @return int
     */
    public function getSchoolClassId()
    {
        return $this->schoolClassId;
    }

    /**
     * Set School Class id
     *
     * @param int $schoolClassId
     * @return void
     */
    public function setSchoolClassId($schoolClassId)
    {
        if(!is_int($schoolClassId))
        {
            throw new InvalidArgumentException('parameter "schoolClassId" can be integer');
        }
        if($schoolClassId < 0)
        {
            throw new OutOfRangeException('parameter "schoolClassId" can not be less than 0');
        }
        $this->schoolClassId = $schoolClassId;
    }

    /**
     * Get Lesson Day id
     *
     * @return int
     */
    public function getLessonDayId()
    {
        return $this->lessonDayId;
    }

    /**
     * Set Lesson Day id
     *
     * @param int $lessonDayId
     * @return void
     */
    public function setLessonDayId($lessonDayId)
    {
        if(!is_int($lessonDayId))
        {
            throw new InvalidArgumentException('parameter "lessonDayId" can be integer');
        }
        if($lessonDayId < 0)
        {
            throw new OutOfRangeException('parameter "lessonDayId" can not be less than 0');
        }
        $this->lessonDayId = $lessonDayId;
    }

    /**
     * Get id by Lesson
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set id by Lesson
     *
     * @param int $id
     * @return void
     */
    public function setId($id)
    {
        if(!is_int($id))
        {
            throw new InvalidArgumentException('parameter "id" can be integer');
        }
        if($id < 0)
        {
            throw new OutOfRangeException('parameter "id" can not be less than 0');
        }
        $this->id = $id;
    }

    /**
     * Get Lesson Day
     *
     * @return LessonDay
     */
    public function getLessonDay()
    {
        return $this->lessonDay;
    }

    /**
     * Set Lesson Day
     *
     * @param LessonDay $lessonDay
     * @return void
     */
    public function setLessonDay($lessonDay)
    {
        if(is_null($lessonDay))
        {
            throw new InvalidArgumentException('parameter "lessonDay" is null');
        }
        if(gettype($lessonDay) != 'LessonDay')
        {
            throw new InvalidArgumentException('invalid type parameter: "lessonDay"');
        }
        $this->lessonDay = $lessonDay;
    }

    /**
     * Get Lesson Number
     *
     * @return int
     */
    public function getLessonNumber()
    {
        return $this->lessonNumber;
    }

    /**
     * Set Lesson Number
     *
     * @param int $lessonNumber
     * @return void
     */
    public function setLessonNumber($lessonNumber)
    {
        if(!is_int($lessonNumber))
        {
            throw new InvalidArgumentException('invalid type argument: "lessonNumber"');
        }
        if($lessonNumber < self::MIN_LESSON_NUMBER || $lessonNumber > self::MAX_LESSON_NUMBER)
        {
            throw new OutOfRangeException('parameter "lessonNumber" can not be less than' . self::MIN_LESSON_NUMBER . 'ot greater than' . self::MAX_LESSON_NUMBER);
        }
        $this->lessonNumber = $lessonNumber;
    }

    /**
     * Get School Class
     *
     * @return SchoolClass
     */
    public function getSchoolClass()
    {
        return $this->schoolClass;
    }

    /**
     * Set School Class
     *
     * @param SchoolClass $schoolClass
     * @return void
     */
    public function setSchoolClass(SchoolClass $schoolClass)
    {
        if(is_null($schoolClass))
        {
            throw new InvalidArgumentException('parameter "schoolClass" is null');
        }
        if(get_class($schoolClass) != 'SchoolClass')
        {
            throw new InvalidArgumentException('invalid type of argument: "schoolClass"');
        }
        $this->schoolClass = $schoolClass;
    }

    /**
     * Get School Room
     *
     * @return SchoolRoom
     */
    public function getSchoolRoom()
    {
        return $this->schoolRoom;
    }

    /**
     * Set School Room
     *
     * @param SchoolRoom $schoolRoom
     * @return void
     */
    public function setSchoolRoom($schoolRoom)
    {
        if(get_class($schoolRoom) != 'SchoolRoom')
        {
            throw new InvalidArgumentException('invalid type of argument: "schoolRoom"');
        }
        $this->schoolRoom = $schoolRoom;
    }

    /**
     * Get Subject
     *
     * @return Subject
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set Subject
     *
     * @param Subject $subject
     * @return void
     */
    public function setSubject($subject)
    {
        if(is_null($subject))
        {
            throw new InvalidArgumentException('parameter "subject" is null');
        }
        if(get_class($subject) != 'Subject')
        {
            throw new InvalidArgumentException('invalid type of argument: "subject"');
        }
        $this->subject = $subject;
    }

    /**
     * Get Teacher
     *
     * @return Teacher
     */
    public function getTeacher()
    {
        return $this->teacher;
    }

    /**
     * Set Teacher
     *
     * @param Teacher $teacher
     * @return void
     */
    public function setTeacher($teacher)
    {
        if(get_class($teacher) != 'Teacher')
        {
            throw new InvalidArgumentException('invalid type of argument: "teacher"');
        }
        $this->teacher = $teacher;
    }

    /**
     * Lesson constructor.
     *
     * @param int $id
     */
    public function __construct($id) // minimal requirements to create class Lesson
    {
        $this->setId($id);
    }
}
