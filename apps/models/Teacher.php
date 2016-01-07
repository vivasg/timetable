<?php

// TODO: допилить
use \Dto\Teacher as Dto,
    \Phalcon\Mvc\Model\Resultset\Simple;

class Teacher
{
    /**
     * @var \Dto\Teacher
     */
    private $dto;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->dto->getId();
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        if(!is_int($id))
        {
            throw new \InvalidArgumentException('invalid type of argument: "id"');
        }
        if($id < 0)
        {
            throw new \OutOfRangeException('parameter "id" can not be less than 0');
        }
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->dto->getNameFirst();
    }

    /**
     * @param string $name_first
     */
    public function setFirstName($name_first)
    {
        if(!is_string($name_first))
        {
            throw new \InvalidArgumentException('invalid type of argument: "firstName"');
        }
        $this->firstName = $name_first;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->dto->getNameLast();
    }

    /**
     * @param string $lastName
     */
    public function setLastName($name_last)
    {
        if(!is_string($name_last))
        {
            throw new \InvalidArgumentException('invalid type of argument: "lastName"');
        }
        $this->lastName = $name_last;
    }

    /**
     * @return int
     */
    public function getMiddleName()
    {
        return $this->dto->getNameMiddle();
    }

    /**
     * @param int $name_middle
     */
    public function setMiddleName($name_middle)
    {
        if(!is_string($name_middle))
        {
            throw new \InvalidArgumentException('invalid type of argument: "middleName"');
        }
        $this->middleName = $name_middle;
    }

    public function __construct(Dto $dto)
    {
        $this->dto = $dto;
    }

    public static function findByName($names)
    {
        $parameters = [
            'conditions' => 'name_first=:name: OR name_last=:name: OR name_middle=:name:',
            'bind' => [
                'name' => $names
            ],
        ];

        /** @var Simple $tmp_teachers */
        $tmp_teachers = Dto::find($parameters);
        if ($tmp_teachers instanceof Simple && $tmp_teachers->count() > 0)
        {
            $return = [];

            /** @var Dto $tmp_teacher */
            foreach ($tmp_teachers as $tmp_teacher)
            {
                $return[] = new Teacher($tmp_teacher);
            }

            return $return;
        }
        return null;
    }
}
