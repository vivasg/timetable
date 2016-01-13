<?php

use \Dto\Subject as Dto,
    \Phalcon\Mvc\Model\Resultset\Simple;

class Subject
{
    /**
     * @var \Dto\Subject
     */
    private $dto;

    /**
     * get subject id
     * @return int
     */
    public function getId()
    {
        return $this->dto->getId();
    }

    /**
     * set subject id
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
     * get subject name
     * @return string
     */
    public function getName()
    {
        return $this->dto->getName();
    }

    /**
     * set subject name
     * @param string $name
     */
    public function setName($name)
    {
        if(!is_string($name))
        {
            throw new \InvalidArgumentException('invalid type of argument: "name"');
        }
        $this->name = $name;
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

        /** @var Simple $tmp_subjects */
        $tmp_subjects = Dto::find($parameters);
        if ($tmp_subjects instanceof Simple && $tmp_subjects->count() > 0)
        {
            $return = [];

            /** @var Dto $tmp_subject */
            foreach ($tmp_subjects as $tmp_subject)
            {
                $return[] = new Subject($tmp_subject);
            }

            return $return;
        }
        return null;
    }
}
