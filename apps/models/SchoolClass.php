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
        if($id < 0)
        {
            throw new \OutOfRangeException('parameter "id" can not be less than 0');
        }
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
    public function __construct(Dto $dto)
    {
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
        /** @var Simple $tmp_schoolclasses */
        $tmp_schoolclasses = Dto::find([
            'order' => 'name'
        ]);
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

    public function save()
    {
        $this->dto->save();
    }
    public function update()
    {
        $this->dto->update();
    }
    public function delete()
    {
        $this->dto->delete();
    }
}
