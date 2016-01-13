<?php

namespace Dto;

use \Phalcon\Mvc\Model,
    Phalcon\Mvc\Model\Validator\PresenceOf,
    Phalcon\Mvc\Model\Validator\StringLength;

/**
 * Class Subject
 * @package Dto
 *
 * @variable \Dto\Lesson $lessons
 */

class Subject extends Model
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $subject_name;

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
        $this->name = $value;
        return $this;
    }

    public function getSource()
    {
        return 'subjects';
    }

    public function initialize()
    {
        $this->hasMany('id', '\Dto\Lesson', 'subject_id', [
            'alias' => 'lessons'
        ]);
    }

    public function validation()
    {
        // Правила для id
        $this->validate(new PresenceOf([
            'field' => 'id',
            'message' => 'Not id in model',
        ]));

        // Правила для name_first
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

    }

    /**
     * @param array|null $parameters
     */
    public function getLessons($parameters = null)
    {
        $this->getRelated('lessons', $parameters);
    }
}