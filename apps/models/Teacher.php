<?php

class Teacher
{
    private $id;
    private $firstName;
    private $middleName;
    private $lastName;

    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        if(!is_int($id))
        {
            throw new InvalidArgumentException('invalid type of argument: "id"');
        }
        if($id < 0)
        {
            throw new OutOfRangeException('parameter "id" can not be less than 0');
        }
        $this->id = $id;
    }
    public function getFirstName()
    {
        return $this->firstName;
    }
    public function setFirstName($firstName)
    {
        if(!is_string($firstName))
        {
            throw new InvalidArgumentException('invalid type of argument: "firstName"');
        }
        $this->firstName = $firstName;
    }
    public function getLastName()
    {
        return $this->lastName;
    }
    public function setLastName($lastName)
    {
        if(!is_string($lastName))
        {
            throw new InvalidArgumentException('invalid type of argument: "lastName"');
        }
        $this->lastName = $lastName;
    }
    public function getMiddleName()
    {
        return $this->middleName;
    }
    public function setMiddleName($middleName)
    {
        if(!is_string($middleName))
        {
            throw new InvalidArgumentException('invalid type of argument: "middleName"');
        }
        $this->middleName = $middleName;
    }

    public function __construct()
    {

    }
}
