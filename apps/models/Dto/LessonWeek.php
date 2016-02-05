<?php

namespace Dto;

use \Phalcon\Mvc\Model;
use Phalcon\MVC\Model\Validator\PresenceOf,
    Phalcon\MVC\Model\Validator\StringLength,
    Phalcon\MVC\Model\Validator\Numericality;

/**
 * Class LessonWeek
 * @package Dto
 *
 * @variable \Dto\LessonWeek LessonWeeks
 */
class LessonWeek extends Model
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $number;

    /**
     * @var string
     */
    private $name;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
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
        $this->id = $id;
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
     *
     * @return $this
     */
    public function setName($name)
    {
        if(!is_string($name))
        {
            throw new \InvalidArgumentException('invalid type of argument: "name"');
        }

        $this->name = $name;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @param int|null $number
     *
     * @return $this
     */
    public function setNumber($number)
    {
        if(!is_int($number))
        {
            throw new \InvalidArgumentException('invalid type of argument: "number"');
        }
        if($number < 0)
        {
            throw new \InvalidArgumentException('number must be biger than 0');
        }
        $this->number = $number;
        return $this;
    }

    /**
     * @return bool
     */
    public function validation()
    {
        //rules with number
        $this->validate(new PresenceOf([
            'field' => 'number',
            'message' => 'Not number in model',
        ]));

        $this->validate(new Numericality([
            'field' => 'number',
            'message' => 'number can be Numeric',
        ]));

        //rules with name
        $this->validate(new StringLength([
            'field' => 'name',
            'max' => 255,
            'min' => 1,
            'messageMaximum' => 'name is to long',
            'messageMinimum' => 'name is to short',
        ]));

        $this->validate(new PresenceOf([
            'field' => 'name',
            'message' => 'Not name in model',
        ]));

        if ($this->validationHasFailed() == true)
        {
            return false;
        }
    }

    /**
     * @param array|null $parameters
     */
    public function getLessons($parameters = null)
    {
        $this->getRelated('lessons', $parameters);
    }

    /** get name table
     * @return string
     */
    public function getSource()
    {
        return 'lesson_weeks';
    }
}
