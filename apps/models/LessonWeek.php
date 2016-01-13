<?php

use \Dto\LessonWeek as Dto,
    \Phalcon\Mvc\Model\Resultset\Simple;

class LessonWeek
{
    /**
     * @var \Dto\LessonWeek
     */
    private $dto;

    /**
     * Get Id by LessonWeek.
     *
     * @return int
     */
    public function getId()
    {
        return $this->dto->getId();
    }

    /**
     * Set Id.
     *
     * @param int $id
     * @return $this
     */
    public function setId($id)
    {
        if(!is_int($id))
        {
            throw new \InvalidArgumentException('invalid type of argument: "id"');
        }
        if($id < 0)
        {
            throw new \OutOfRangeException('parameter "id" can not be less than 0');
        }
        $this->dto->setId($id);
        return $this;
    }

    /**
     * Get Week name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->dto->getName();
    }

    /**
     * Set Week name.
     *
     * @param string $name
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
     * Get number Week.
     *
     * @return int
     */
    public function getNumber()
    {
        return $this->dto->getNumber();
    }
    /**
     * Set number of a Week.
     *
     * @param int $number
     * @return $this
     */
    public function setNumber($number)
    {
        if(!is_int($number))
        {
            throw new \InvalidArgumentException('invalid type of argument: "number"');
        }
        $this->dto->setNumber($number);
        return $this;
    }

    /**
     * LessonWeek constructor.
     * @param \Dto\LessonWeek $dto
     */
    public function __construct($dto)
    {
        $this->dto = $dto;
    }

    /**Select Lesson Week by Name
     * @param $names
     * @param int $count
     * @return array|null
     */
    public static function findByName($names, $count = 100)
    {
        $parameters = [
            'conditions' => 'name=:name:',
            'bind' => [
                'name' => $names
            ],
        ];

        return LessonWeek::getMany($parameters, $count);
    }

    /**Select Lesson Week by Id
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
        return LessonWeek::getMany($parameters, 1);
    }

    /**Select Lesson Week by Number
     * @param $numbers
     * @param int $count
     * @return array|null
     */
    public static function findByNuber($numbers, $count = 100)
    {
        $parameters = [
            'conditions' => 'number=:number:',
            'bind' => [
                'number' => $numbers
            ],
        ];
        return LessonWeek::getMany($parameters, $count);
    }

    /** return one selected item
     * @param $parameters
     * @return LessonWeek|null
     */
    public static function getOne($parameters)
    {
        /** @var Simple $tmp_lesson_week */
        $tmp_lesson_week = Dto::findFirst($parameters);
        if ($tmp_lesson_week instanceof Simple && $tmp_lesson_week->count() > 0)
        {
            return new LessonWeek($tmp_lesson_week->getFirst());//**???
        }
        return null;
    }

    /** Return an array of the selected items
     * @param $parameters
     * @param $count
     * @return array|null
     */
    public static function getMany($parameters, $count)
    {
        /** @var Simple $tmp_lesson_weeks */
        $tmp_lesson_weeks = Dto::find($parameters);
        if ($tmp_lesson_weeks instanceof Simple && $tmp_lesson_weeks->count() > 0)
        {
            $return = [];

            /** @var Dto $tmp_lesson_weeks */
            foreach ($tmp_lesson_weeks as $tmp_lesson_week)
            {
                $return[] = new LessonWeek($tmp_lesson_week);

                $count--;
                if($count == 0)break;
            }

            return $return;
        }
        return null;
    }
}
