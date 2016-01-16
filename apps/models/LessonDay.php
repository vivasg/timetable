<?php

use \Dto\LessonDay as Dto,
    \Phalcon\Mvc\Model\Resultset\Simple;
class LessonDay
{
    /**
     * @var \Dto\LessonDay
     */
    private $dto;

    /**
     * Get id by LessonDay.
     *
     * @return int|null
     */
    public function getId()
    {
        return $this->dto->getId();
    }

    /**
     * Set id.
     *
     * @param int|null $id
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
     * Get Lesson Week.
     *
     * @return LessonWeek|null
     */
    public function getLessonWeek()
    {
        return $this->dto->getLessonWeek();
    }

    /**
     * Set Lesson Week.
     *
     * @param LessonWeek|null $lessonWeek
     * @return $this
     */
    public function setLessonWeek($lessonWeek)
    {
        if(is_null($lessonWeek))
        {
            throw new \InvalidArgumentException('parameter "lessonWeek" is null');
        }
        if(get_class($lessonWeek) != 'LessonWeek')
        {
            throw new \InvalidArgumentException('invalid type of argument: "lessonWeek"');
        }
        $this->dto->setLessonWeek($lessonWeek);
        return $this;
    }

    /**
     * Get Week Day.
     *
     * @return int|null
     */
    public function getWeekday()
    {
        return $this->dto->getWeekDay();
    }

    /**
     * Set Week Day.
     *
     * @param int|null $weekDay
     * @return $this
     */
    public function setWeekday($weekDay)
    {
        if(!is_int($weekDay))
        {
            throw new \InvalidArgumentException('invalid type of argument: "weekDay"');
        }
        $this->dto->setWeekDay($weekDay);
        return $this;
    }

    /**
     * Get Name.

     * @return string|null
     */
    public function getName()
    {
        return $this->dto->getName();
    }

    /**
     * Set Name.
     *
     * @param string|null $name
     * @return $this
     */
    public function setName($name)
    {
        if(!is_string($name))
        {
            throw new \InvalidArgumentException('invalid type of argument: "name"');
        }
        $this->dto->setName($name);
        return $this;
    }

    /**
     * Get Lesson max count.
     *
     * @return int|null
     */
    public function getLessonMaxCount()
    {
        return $this->dto->getLessonMaxCount();
    }

    /**
     * Set Lesson max count.
     *
     * @param int $lessonMaxCount
     * @return $this
     */
    public function setLessonMaxCount($lessonMaxCount)
    {
        if(!is_int($lessonMaxCount))
        {
            throw new \InvalidArgumentException('invalid type of argument: "lessonMaxCount"');
        }
        $this->dto->setLessonMaxCount($lessonMaxCount);
        return $this;
    }

    /**
     * LessonDay constructor.
     */
    public function __construct($dto)
    {
        $this->dto = $dto;
    }

    /**Get Lesson Day by Id
     * @param $id
     * @return array|null
     */
    public static function findById($id)
    {
        $parameters = [
            'conditions' => 'id=:id:',
            'bind' => [
                'id' => $id
            ],
        ];
        return LessonDay::getOne($parameters);
    }

    /**Select Lesson Day by Name
     * @param $names
     * @param int $count
     * @return array|null
     */
    public static function findByName($names)
    {
        $parameters = [
            'conditions' => 'name=:name:',
            'bind' => [
                'name' => $names
            ],
        ];
        return LessonDay::getMany($parameters);
    }

    /**Select Lesson Day by Week Day
     * @param $weekDays
     * @param int $count
     * @return array|null
     */
    public static function findByWeekDay ($weekDays)
    {
        $parameters = [
            'conditions' => 'wday=:wday:',
            'bind' => [
                'wday' => $weekDays
            ],
        ];
        return LessonDay::getMany($parameters);
    }

    /**Select Lesson Day by Lesson Max Count(per Day)
     * @param $lessonMaxCounts
     * @param int $count
     * @return array|null
     */
    public static function findByLessonMaxCount($lessonMaxCounts)
    {
        $parameters = [
            'conditions' => 'lesson_max_count=:value:',
            'bind' => [
                'value' => $lessonMaxCounts
            ],
        ];
        return LessonDay::getMany($parameters);
    }

    /**Return an array of the selected items
     * @param $parameters
     * @param $count
     * @return array|null
     */
    public static function getMany($parameters)
    {
        /** @var Simple $tmp_lesson_day */
        $tmp_lesson_day = Dto::find($parameters);
        if ($tmp_lesson_day instanceof Simple && $tmp_lesson_day->count() > 0)
        {
            $return = [];

            /** @var Dto $tmp_lesson_weeks */
            foreach ($tmp_lesson_day as $tmp_lesson_day)
            {
                $return[] = new LessonDay($tmp_lesson_day);
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
        $tmp_lesson_day = Dto::findFirst($parameters);
        if ($tmp_lesson_day instanceof Dto)
        {
            return new Lesson($tmp_lesson);
        }
        return null;
    }
}
