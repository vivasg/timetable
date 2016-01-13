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
        if(!is_int($id))
        {
            throw new \InvalidArgumentException('invalid type of argument: "id"');
        }
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
        if(!is_string($name))
        {
            throw new \InvalidArgumentException('invalid type of argument: "name"');
        }
        $this->dto->setName($name);
    }

    public function __construct(Dto $dto)
    {
        $this->dto = $dto;
    }

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
}
