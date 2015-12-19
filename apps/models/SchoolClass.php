<?php
class SchoolClass
{
    private $id;
    private $name;

    /**
     * get schoolclass id
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * set schoolclass id
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
     * get week name
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        if(!is_string($name))
        {
            throw new InvalidArgumentException('invalid type of argument: "name"');
        }
        $this->name = $name;
    }

    public function __construct()
    {
    }
}
