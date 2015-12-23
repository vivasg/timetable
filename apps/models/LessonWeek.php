<?php
class LessonWeek
{
    /**
     * @var \Dto\LessonWeek
     */
    private $dto;

    /**
     * Get Id by LessonWeek.
     *
     * @return int
     */
    public function getId()
    {
        return $this->dto->getId();
    }

    /**
     * Set Id.
     *
     * @param int $id
     * @return $this
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
        $this->dto->setId($id);
        return $this;
    }

    /**
     * Get Week name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->dto->getName();
    }

    /**
     * Set Week name.
     *
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        if(!is_string($name))
        {
            throw new InvalidArgumentException('invalid type of argument: "name"');
        }
        $this->dto->setName($name);
        return $this;
    }

    /**
     * Get number Week.
     *
     * @return int
     */
    public function getNumber()
    {
        return $this->dto->getNumber();
    }
    /**
     * Set number of a Week.
     *
     * @param int $number
     * @return this
     */
    public function setNumber($number)
    {
        if(!is_int($number))
        {
            throw new InvalidArgumentException('invalid type of argument: "number"');
        }
        $this->dto->setNumber($number);
        return $this;
    }

    /**
     * LessonWeek constructor.
     */
    public function __construct()
    {
    }
}
