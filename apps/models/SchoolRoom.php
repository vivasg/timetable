<?php

use \Dto\SchoolRoom as Dto,
    \Phalcon\Mvc\Model\Resultset\Simple;

class SchoolRoom
{
    /**
     * @var \Dto\SchoolRoom
     */
    private $dto;

    /**
     * get schoolroom id
     * @return int
     */
    public function getId()
    {
        return $this->dto->getId();
    }

    /**
     * set schoolroom id
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
     * get schoolroom name
     * @return string
     */
    public function getName()
    {
        return $this->dto->getName();
    }

    /**
     * set schoolroom name
     * @param string $name
     */
    public function setName($name)
    {
        $this->dto->setName($name);
    }

    public function __construct(Dto $dto = null)
    {
        if (is_null($dto))
        {
            $dto = new Dto();
        }
        $this->dto = $dto;
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
            'conditions' => 'name=:name:',
            'bind' => [
                'name' => $names
            ],
        ];

        /** @var Simple $tmp_schoolrooms */
        $tmp_schoolrooms = Dto::find($parameters);
        if ($tmp_schoolrooms instanceof Simple && $tmp_schoolrooms->count() > 0)
        {
            $return = [];

            /** @var Dto $tmp_schoolroom */
            foreach ($tmp_schoolrooms as $tmp_schoolroom)
            {
                $return[] = new SchoolRoom($tmp_schoolroom);
            }

            return $return;
        }
        return null;
    }

    /**
     * @param $id
     * @return array|null
     */
    public static function findById($id)
    {
        $parameters = [
            'conditions' => 'id=:id:',
            'bind' => [
                'id' => $id
            ],
        ];

        /** @var Dto $tmp_schoolroom */
        $tmp_schoolroom = Dto::findFirst($parameters);
        if ($tmp_schoolroom instanceof Dto)
        {
            return new SchoolRoom($tmp_schoolroom);
        }
        return null;
    }
    public static function find()
    {
        $tmp_schoolrooms = Dto::find();
        if ($tmp_schoolrooms instanceof Simple && $tmp_schoolrooms->count() > 0)
        {
            $return = [];

            /** @var Dto $tmp_schoolroom */
            foreach ($tmp_schoolrooms as $tmp_schoolroom)
            {
                $return[] = new SchoolRoom($tmp_schoolroom);
            }

            return $return;
        }
        return null;
    }

    public function getResponseData()
    {
        /** @var SchoolRoom $object */
        $data[] = [
            'type' => 'SchoolRoom',
            'id' => $this->getId(),
            'attributes' => [
                'name' => $this->getName(),
            ],
        ];
        return $data;
    }

    public function save()
    {
        $status = $this->dto->save();
        if(!$status)
        {
            return $this->dto->getMessages();
        }
        return false;
    }

    public function create($data = null)
    {
        $status = $this->dto->create();
        if(!$status)
        {
            return $this->dto->getMessages();
        }
        return false;
    }

    public function update()
    {
        $status = $this->dto->update();
        if(!$status)
        {
            return $this->dto->getMessages();
        }
        return false;
    }

    public function delete()
    {
        return $this->dto->delete();
    }
}
