<?php

// TODO: допилить

class Teacher
{
    /**
     * @var \Dto\Teacher
     */
    private $model;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->model->getId();
    }

    /**
     * @param int $id
     */
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

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        if(!is_string($firstName))
        {
            throw new InvalidArgumentException('invalid type of argument: "firstName"');
        }
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        if(!is_string($lastName))
        {
            throw new InvalidArgumentException('invalid type of argument: "lastName"');
        }
        $this->lastName = $lastName;
    }

    /**
     * @return int
     */
    public function getMiddleName()
    {
        return $this->middleName;
    }

    /**
     * @param int $middleName
     */
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
