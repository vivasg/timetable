<?php
class LessonWeek
{
    private $id;
    private $number;
    private $name;

    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        if(is_int($id))
        {
            throw new InvalidArgumentException('invalid type of argument: "id"');
        }
        if($id < 0)
        {
            throw new OutOfRangeException('parameter "id" can not be less than 0');
        }
        $this->id = $id;
    }
    public function getName()
    {
        return $this->name;
    }
    public function setName($name)
    {
        if(!is_string($name))
        {
            throw new InvalidArgumentException('invalid type of argument: "name"');
        }
        $this->name = $name;
    }
    public function getNumber()
    {
        return $this->number;
    }
    public function setNumber($number)
    {
        if(!is_int($number))
        {
            throw new InvalidArgumentException('invalid type of argument: "number"');
        }
        $this->number = $number;
    }
    public function __construct()
    {
    }
}
