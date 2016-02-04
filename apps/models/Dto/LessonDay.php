<?php

namespace Dto;

use \Phalcon\Mvc\Model,
    Phalcon\Mvc\Model\Validator\PresenceOf,
    Phalcon\Mvc\Model\Validator\StringLength;
/**
 * @package Dto
 * @property \Dto\LessonWeek $week
 */
class LessonDay extends Model
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var LessonWeek
     */
    //private $lessonWeek;
    /**
     * @var int
     */
    private $lesson_week_id;

    /**
     * @var int
     */
    private $wday;

    /**
     * @var string
     */
    private $name;

    /**
     * @var int
     */
    private $lesson_max_count;

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
        if (!is_int($id))
        {
            throw new \InvalidArgumentException('parameter "id" can be integer');
        }
        if ($id < 0)
        {
            throw new \OutOfRangeException('parameter "id" can not be less than 0');
        }
        $this->id = $id;
        return $this;
    }

    /**
     * @return LessonWeek
     */
    public function getLessonWeek()
    {
        return $this->week;
    }

    /**
     * @param LessonWeek|null $lessonWeek
     * @return $this
     */
    public function setLessonWeek($lessonWeek)
    {
        if (is_null($lessonWeek))
        {
            throw new \InvalidArgumentException('parameter "lessonWeek" is null');
        }
        if ($lessonWeek instanceof \LessonWeek)
        {
            throw new \InvalidArgumentException('invalid type of argument: "lessonWeek"');
        }
        $this->lessonWeek = $lessonWeek;
        return $this;
    }

    /**
     * @return int
     */
    public function getLessonWeekId()
    {
        return $this->lesson_week_id;
    }

    /**
     * @param int $lesson_week_id
     * @return $this
     */
    public function setLessonWeekId($lesson_week_id)
    {
        if (!is_int($lesson_week_id))
        {
            throw new \InvalidArgumentException('parameter lessonWeekId mus t be int');
        }
        if ($lesson_week_id < 0)
        {
            throw new \InvalidArgumentException('lessonWeekId must be biger than 0');
        }
        $this->lesson_week_id = $lesson_week_id;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getWeekDay()
    {
        return $this->wday;
    }

    /**
     * @param int|null $wday
     * @return $this
     */
    public function setWeekDay($wday)
    {
        if (!is_int($wday))
        {
            throw new \InvalidArgumentException('invalid type of argument: "weekDay"');
        }
        $this->wday = $wday;
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
        if (!is_string($name))
        {
            throw new \InvalidArgumentException('invalid type of argument: "name"');
        }
        $this->name = $name;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getLessonMaxCount()
    {
        return $this->lesson_max_count;
    }

    /**
     * @param int|null $lesson_max_count
     * @return $this
     */
    public function setLessonMaxCount($lesson_max_count)
    {
        if (!is_int($lesson_max_count))
        {
            throw new \InvalidArgumentException('invalid type of argument: "lessonMaxCount"');
        }
        $this->lesson_max_count = $lesson_max_count;
        return $this;
    }

    public function getSource()
    {
        return 'lesson_days';
    }

    public function initialize()
    {
        $this->setSource('lesson_days');
        $this->hasMany('id', '/Dto/Lesson', 'lesson_day_id', [
            'alias' => 'lessons'
        ]);
        $this->belongsTo('lesson_week_id', 'Dto\LessonWeek', 'id', [
            'alias' => 'week'
        ]);
    }

    public function validation()
    {

        // rules for lessonWeekid
        $this->validate(new PresenceOf([
            'field' => 'lesson_week_id',
            'message' => 'Not lessonWeekid in model',
        ]));

        // rules for weekDay
        $this->validate(new PresenceOf([
            'field' => 'wday',
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
            'field' => 'lesson_max_count',
            'message' => 'Not lessonMaxCount in model',
        ]));
    }

    /** get name table
     * @return string
     */

}