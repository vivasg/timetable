<?php

namespace Dto;

use \Phalcon\Mvc\Model,
    \Phalcon\Mvc\Model\Validator\PresenceOf,
    \Phalcon\Mvc\Model\Validator\StringLength;

/**
 * Class SchoolClass
 * @package Dto
 *
 * @variable \Dto\Lesson $lessons
 */
class SchoolClass extends Model
{
    /**
     * @var int
     */
    private $id;

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
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param int $value
     *
     * @return $this
     */
    public function setId($value)
    {
        if(!is_int($value))
        {
            throw new \InvalidArgumentException('invalid type of argument: "id"');
        }
        if($value < 0)
        {
            throw new \OutOfRangeException('parameter "id" can not be less than 0');
        }
        $this->id = $value;
        return $this;
    }

    /**
     * @param string|null $value
     *
     * @return $this
     */
    public function setName($value)
    {
        if(!is_string($value))
        {
            throw new \InvalidArgumentException('invalid type of argument: "name"');
        }
        $this->name = $value;
        return $this;
    }

    public function initialize()
    {
        $this->hasMany('id', '\Dto\Lesson', 'school_class_id', [
            'alias' => 'lessons'
        ]);
    }

    public function getSource()
    {
        return 'school_classses';
    }

    public function validation()
    {

        // Правила для name
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

        if ($this->validationHasFailed() == true)
        {
            return false;
        }

        return true;

    }

    /**
     * @param array|null $parameters
     */
    public function getLessons($parameters = null)
    {
        $this->getRelated('lessons', $parameters);
    }
}