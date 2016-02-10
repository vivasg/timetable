<?php

namespace Dto;

use \Phalcon\Mvc\Model,
    \Phalcon\Mvc\Model\Validator\PresenceOf,
    \Phalcon\Mvc\Model\Validator\StringLength;

/**
 * Class SchoolRoom
 * @package Dto
 *
 * @variable \Dto\Lesson $lessons
 */
class SchoolRoom extends Model
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

    public function getSource()
    {
        return 'school_rooms';
    }

    public function initialize()
    {
        $this->hasMany('id', '\Dto\Lesson', 'school_room_id', [
            'alias' => 'lessons'
        ]);
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