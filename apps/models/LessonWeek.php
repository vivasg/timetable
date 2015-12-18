<?php
class LessonWeek
{
    private $id;
    private $number;
    private $name;

    /**
     * Get Id by LessonWeek.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set Id.
     *
     * @param int $id
     * @return void
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
     * Get Week name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set Week name.
     *
     * @param string $name
     * @return void
     */
    public function setName($name)
    {
        if(!is_string($name))
        {
            throw new InvalidArgumentException('invalid type of argument: "name"');
        }
        $this->name = $name;
    }

    /**
     * Get number Week.
     *
     * @return int
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set number of a Week.
     *
     * @param int $number
     * @return void
     */
    public function setNumber($number)
    {
        if(!is_int($number))
        {
            throw new InvalidArgumentException('invalid type of argument: "number"');
        }
        $this->number = $number;
    }

    /**
     * LessonWeek constructor.
     */
    public function __construct()
    {
    }
}
