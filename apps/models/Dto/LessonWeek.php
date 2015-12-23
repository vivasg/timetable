<?php

namespace Dto;

use \Phalcon\Mvc\Model;
use Phalcon\Validation\Validator\PresenceOf;

/**
 * Class LessonWeek
 * @package Dto
 *
 * @variable \Dto\LessonDay lessonDays
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
        $this->number = $number;
        return $this;
    }

    /**
     * @return bool
     */
    public function validation()
    {
        //rules with id
        $this->validate(new PresenceOf([
            'field' => 'id',
            'message' => 'Not id in model',
        ]));

        //rules with number
        $this->validate(new PresenceOf([
            'field' => 'number',
            'message' => 'Not name in model',
        ]));

        $this->validate(new InvalidValue([
            'field' => 'number',
            'message' => 'invalid value',
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
}
