<?php
class SchoolRoom
{
    private $id;
    private $name;

    /**
     * get schoolroom id
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * set schoolroom id
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
     * get schoolroom name
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * set schoolroom name
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
