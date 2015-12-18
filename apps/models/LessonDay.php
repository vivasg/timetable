<?php
class LessonDay
{
    private $id;
    private $lessonWeek;
    private $weekDay;
    private $name;
    private $lessonMaxCount;

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

    public function getLessonWeek()
    {
        return $this->lessonWeek;
    }
    public function setLessonWeek($lessonWeek)
    {
        if(is_null($lessonWeek))
        {
            throw new InvalidArgumentException('parameter "lessonWeek" is null');
        }
        if(get_class($lessonWeek) != 'LessonWeek')
        {
            throw new InvalidArgumentException('invalid type of argument: "lessonWeek"');
        }
        $this->lessonWeek = $lessonWeek;
    }
    public function getWeekday()
    {
        return $this->weekDay;
    }
    public function setWeekday($weekDay)
    {
        if(!is_string($weekDay))
        {
            throw new InvalidArgumentException('invalid type of argument: "weekDay"');
        }
        $this->weekDay = $weekDay;
    }
    public function getName()
    {
        return $this->name;
    }
    public function setName($name)
    {
        if(!is_string($name))
        {
            throw new InvalidArgumentException('invalid type of argument: "name"');
        }
        $this->name = $name;
    }
    public function getLessonMaxCount()
    {
        return $this->lessonMaxCount;
    }
    public function setLessonMaxCount($lessonMaxCount)
    {
        if(!is_int($lessonMaxCount))
        {
            throw new InvalidArgumentException('invalid type of argument: "lessonMaxCount"');
        }
        $this->lessonMaxCount = $lessonMaxCount;
    }

    public function __construct()
    {

    }
}
