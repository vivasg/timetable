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
     * @return string
     */
    public function getNameShort()
    {
        return $this->dto->getNameShort();
    }

    /**
     * @return string
     */
    public function getNameFull()
    {
        return $this->dto->getNameFull();
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        if($id < 0)
        {
            throw new \OutOfRangeException('parameter "id" can not be less than 0');
        }
        $this->dto->setId($id);
    }

    /**
     * @return string
     */
    public function getNameFirst()
    {
        return $this->dto->getNameFirst();
    }

    /**
     * @param string $name_first
     */
    public function setNameFirst($name_first)
    {
        $this->dto->setNameFirst($name_first);
    }

    /**
     * @return string
     */
    public function getNameLast()
    {
        return $this->dto->getNameLast();
    }

    /**
     * @param string $name_last
     */
    public function setNameLast($name_last)
    {
        $this->dto->setNameLast($name_last);
    }

    /**
     * @return string
     */
    public function getNameMiddle()
    {
        return $this->dto->getNameMiddle();
    }

    /**
     * @param string $name_middle
     */
    public function setNameMiddle($name_middle)
    {
        $this->dto->setNameMiddle($name_middle);
    }

    public function __construct(Dto $dto)
    {
        $this->dto = $dto;
    }

    /**
     * @param $id
     * @return Teacher|null
     */
    public static function findById($id)
    {
        $parameters = [
            'conditions' => 'id=:id:',
            'bind' => [
                'id' => $id
            ],
        ];

        /** @var Dto $tmp_teacher */
        $tmp_teacher = Dto::findFirst($parameters);
        if ($tmp_teacher instanceof Dto)
        {
           return new Teacher($tmp_teacher);
        }
        return null;
    }

    /**
     * Search by argument names in the database
     *
     * @param string $names
     * @return array|null
     */
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

    public static function find()
    {
        $tmp_teachers = Dto::find();
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

    public function save()
    {
        $this->dto->save();
        $msg = $this->dto->getMessages();
        if ($msg)
        {
            return $msg;
        }
        return true;
    }

    public function delete()
    {
        $this->dto->delete();
    }
    public function getResponseData()
    {
        /** @var Teacher $object */
        $data[] = [
            'type' => 'Teacher',
            'id' => $this->getId(),
            'attributes' => [
                'title' => 'teacher',
                'name_first' => $this->getNameFirst(),
                'name_middle' => $this->getNameMiddle(),
                'name_last' => $this->getNameLast(),
                'name_full' => $this->getNameFull(),
                'name_short' => $this->getNameShort()
            ],
        ];
        return $data;
    }
}
