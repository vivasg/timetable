<?php

namespace Dto;

use \Phalcon\Mvc\Model,
    Phalcon\Mvc\Model\Validator\PresenceOf,
    Phalcon\Mvc\Model\Validator\StringLength;

class LessonDay extends Model
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var LessonWeek
     */
    private $lessonWeek;
    /**
     * @var int
     */
    private $lessonWeekId;

    /**
     * @var int
     */
    private $weekDay;

    /**
     * @var string
     */
    private $name;

    /**
     * @var int
     */
    private $lessonMaxCount;

    /**
     * @return int|null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return LessonWeek
     */
    public function getLessonWeek()
    {
        return $this->lessonWeek;
    }

    /**
     * @param LessonWeek $lessonWeek
     * @return $this
     */
    public function setLessonWeek($lessonWeek)
    {
        $this->lessonWeek = $lessonWeek;
        return $this;
    }

    /**
     * @return int
     */
    public function getLessonWeekId()
    {
        return $this->lessonWeekId;
    }

    /**
     * @param int $lessonWeekId
     * @return $this
     */
    public function setLessonWeekId($lessonWeekId)
    {
        $this->lessonWeekId = $lessonWeekId;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getWeekDay()
    {
        if(is_null($this->weekDay))
        {
            getWeekDay();
        }
        return $this->weekDay;
    }

    /**
     * @param int|null $weekDay
     * @return $this
     */
    public function setWeekDay($weekDay)
    {
        $this->weekDay = $weekDay;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getLessonMaxCount()
    {
        return $this->lessonMaxCount;
    }

    /**
     * @param int|null $lessonMaxCount
     * @return $this
     */
    public function setLessonMaxCount($lessonMaxCount)
    {
        $this->lessonMaxCount = $lessonMaxCount;
        return $this;
    }

    public function initialize()
    {

    }

    public function validation()
    {
        // rules for id
        $this->validate(new PresenceOf([
            'field' => 'id',
            'message' => 'Not id in model',
        ]));

        // rules for lessonWeek
        $this->validate(new PresenceOf([
            'field' => 'lessonWeek',
            'message' => 'Not lessonWeek in model',
        ]));

        // rules for lessonWeekid
        $this->validate(new PresenceOf([
            'field' => 'lessonWeekid',
            'message' => 'Not lessonWeekid in model',
        ]));

        // rules for weekDay
        $this->validate(new PresenceOf([
            'field' => 'weekDay',
            'message' => 'Not weekDay in model',
        ]));

        // rules for name
        $this->validate(new PresenceOf([
            'field' => 'name',
            'message' => 'Not name in model',
        ]));

        $this->validate(new StringLength([
            'field' => 'name',
            'max' => 255,
            'min' => 1,
            'messageMaximum' => 'name is to long',
            'messageMinimum' => 'name is to short',
        ]));

        // rules for lessonMaxCount
        $this->validate(new PresenceOf([
            'field' => 'lessonMaxCount',
            'message' => 'Not lessonMaxCount in model',
        ]));
    }
}