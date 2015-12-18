<?php
class Lesson
{
    private $id;
    private $lessonDay;
    private $lessonNumber;
    private $schoolClass;
    private $subject;
    private $schoolRoom;
    private $teacher;
    const MAX_LESSON_DAY = '6';
    const MIN_LESSON_DAY = '0';
    const MAX_LESSON_NUMBER = '13';
    const MIN_LESSON_NUMBER = '0';

    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        if(is_int($id))
        {
            throw new InvalidArgumentException('parameter "id" can be integer');
        }
        if($id < 0)
        {
            throw new OutOfRangeException('parameter "id" can not be less than 0');
        }
        $this->id = $id;
    }
    public function getLessonDay()
    {
        return $this->lessonDay;
    }
    public function setLessonDay($lessonDay)
    {
        if(!is_integer($lessonDay))
        {
            throw new InvalidArgumentException('invalid type parameter: "lessonDay"');
        }
        if($lessonDay < MIN_LESSON_DAY || $lessonDay > MAX_LESSON_DAY)
        {
            throw new OutOfRangeException('parameter "lessonDay" can not be less than'.MIN_LESSON_DAY.'or greater than'.MAX_LESSON_DAY);
        }
        $this->lessonDay = $lessonDay;
    }
    public function getLessonNumber()
    {
        return $this->lessonNumber;
    }
    public function setLessonNumber($lessonNumber)
    {
        if(!is_int($lessonNumber))
        {
            throw new InvalidArgumentException('invalid type argument: "lessonNumber"');
        }
        if($lessonNumber < MIN_LESSON_NUMBER || $lessonNumber > MAX_LESSON_NUMBER)
        {
            throw new OutOfRangeException('parameter "lessonNumber" can not be less than'.MIN_LESSON_NUMBER.'ot greater than'.MAX_LESSON_NUMBER);
        }
        $this->lessonNumber = $lessonNumber;
    }
    public function getSchoolClass()
    {
        return $this->schoolClass;
    }
    public function setSchoolClass(SchoolClass $schoolClass)
    {
        if(is_null($schoolClass))
        {
            throw new InvalidArgumentException('parameter "schoolClass" is null');
        }
        if(gettype($schoolClass) != 'SchoolClass')
        {
            throw new InvalidArgumentException('invalid type of argument: "schoolClass"');
        }
        $this->schoolClass = $schoolClass;
    }
    public function getSchoolRoom()
    {
        return $this->schoolRoom;
    }
    public function setSchoolRoom($schoolRoom)
    {
        if(get_class($schoolRoom) != 'SchoolRoom')
        {
            throw new InvalidArgumentException('invalid type of argument: "schoolRoom"');
        }
        $this->schoolRoom = $schoolRoom;
    }
    public function getSubject()
    {
        return $this->subject;
    }
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
    public function getTeacher()
    {
        return $this->teacher;
    }
    public function setTeacher($teacher)
    {
        if(get_class($teacher) != 'Teacher')
        {
            throw new InvalidArgumentException('invalid type of argument: "teacher"');
        }
        $this->teacher = $teacher;
    }

    public function __construct($id) // minimal requirements to create class Lesson
    {
        $this->setId($id);
    }
}
