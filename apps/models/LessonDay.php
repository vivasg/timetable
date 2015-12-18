<?php
class LessonDay
{
    private $id;
    private $lessonWeek;
    private $weekDay;
    private $name;
    private $lessonMaxCount;

    /**
     * Get id by LessonDay.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set id.
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
     * Get Lesson Week.
     *
     * @return LessonWeek
     */
    public function getLessonWeek()
    {
        return $this->lessonWeek;
    }

    /**
     * Set Lesson Week.
     *
     * @param LessonWeek $lessonWeek
     * @return void
     */
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

    /**
     * Get Week Day.
     *
     * @return int
     */
    public function getWeekday()
    {
        return $this->weekDay;
    }

    /**
     * Set Week Day.
     *
     * @param int $weekDay
     * @return void
     */
    public function setWeekday($weekDay)
    {
        if(!is_int($weekDay))
        {
            throw new InvalidArgumentException('invalid type of argument: "weekDay"');
        }
        $this->weekDay = $weekDay;
    }

    /**
     * Get Name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set Name.
     *
     * @param string $name
     * @return void
     */
    public function setName($name)
    {
        if(!is_string($name))
        {
            throw new InvalidArgumentException('invalid type of argument: "name"');
        }
        $this->name = $name;
    }

    /**
     * Get Lesson max count.
     *
     * @return int
     */
    public function getLessonMaxCount()
    {
        return $this->lessonMaxCount;
    }

    /**
     * Set Lesson max count.
     *
     * @param int $lessonMaxCount
     * @return void
     */
    public function setLessonMaxCount($lessonMaxCount)
    {
        if(!is_int($lessonMaxCount))
        {
            throw new InvalidArgumentException('invalid type of argument: "lessonMaxCount"');
        }
        $this->lessonMaxCount = $lessonMaxCount;
    }

    /**
     * LessonDay constructor.
     */
    public function __construct()
    {

    }
}
