<?php

use \Dto\SchoolClass as Dto,
    \Phalcon\Mvc\Model\Resultset\Simple;

class SchoolClass
{
    /**
     * @var Dto
     */
    private $dto;

    public function getId()
    {
        return $this->dto->getId();
    }

    /**
     * set schoolclass id
     * @param int $id
     */
    public function setId($id)
    {
        $this->dto->setId($id);
    }

    /**
     * get week name
     * @return string
     */
    public function getName()
    {
        return $this->dto->getName();
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->dto->setName($name);
    }

    /**
     * SchoolClass constructor.
     * @param Dto $dto
     */
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

        /** @var Simple $tmp_schoolclasses */
        $tmp_schoolclasses = Dto::find($parameters);
        if ($tmp_schoolclasses instanceof Simple && $tmp_schoolclasses->count() > 0)
        {
            $return = [];

            /** @var Dto $tmp_schoolclass */
            foreach ($tmp_schoolclasses as $tmp_schoolclass)
            {
                $return[] = new SchoolClass($tmp_schoolclass);
            }

            return $return;
        }
        return null;
    }

    public static function find()
    {
        $tmp_schoolclasses = Dto::find();
        if ($tmp_schoolclasses instanceof Simple && $tmp_schoolclasses->count() > 0)
        {
            $return = [];

            /** @var Dto $tmp_schoolclass */
            foreach ($tmp_schoolclasses as $tmp_schoolclass)
            {
                $return[] = new SchoolClass($tmp_schoolclass);
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

        /** @var Dto $tmp_schoolclass */
        $tmp_schoolclass = Dto::findFirst($parameters);
        if ($tmp_schoolclass instanceof Dto)
        {
            return new SchoolClass($tmp_schoolclass);
        }
        return null;
    }

    public function getResponseData()
    {
        /** @var SchoolClass $object */
        $data[] = [
            'type' => 'SchoolClass',
            'id' => $this->getId(),
            'attributes' => [
                'name' => $this->getName()
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
