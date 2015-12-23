<?php

namespace Dto;

use \Phalcon\Mvc\Model,
    \Phalcon\Mvc\Model\Validator\PresenceOf,
    \Phalcon\Mvc\Model\Validator\StringLength;

/**
 * Class SchoolClass
 * @package Dto
 *
 * @variable \Dto\Lesson schoolClass
 */
class SchoolClass
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

    public function initialize()
    {
        $this->hasMany('id', '\Dto\Lesson', 'school_class_id', [
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
            'message' => 'Not name_first in model',
        ]));

        $this->validate(new StringLength([
            'field' => 'name',
            'max' => 255,
            'min' => 1,
            'messageMaximum' => 'name_first is to long',
            'messageMinimum' => 'name_first is to short',
        ]));

    }