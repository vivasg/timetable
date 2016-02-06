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
        $this->dto->setId($id);
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
     * @return string
     */
    public function getShortestName()
    {
        return $this->dto->getShortestName();
    }

    /**
     * @return string
     */
    public function getShortName()
    {
        return $this->dto->getShortName();
    }

    /**
     *Search by argument names in the database
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

    public static function find()
    {
        $tmp_subjects = Dto::find();
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
    /**
     * @param $id
     * @return Subject|null
     */
    public static function findById($id)
    {
        $parameters = [
            'conditions' => 'id=:id:',
            'bind' => [
                'id' => $id
            ],
        ];

        /** @var Dto $tmp_subjects */
        $tmp_subject = Dto::findFirst($parameters);
        if ($tmp_subject instanceof Dto)
        {
            return new Subject($tmp_subject);
        }
        return null;
    }
    public function getResponseData()
    {
        /** @var Subject $object */
        $data[] = [
            'type' => 'Subject', // спросить про заглавную букву(Subject или subject) касаеться всех запросов
            'id' => $this->getId(),
            'attributes' => [
                'name' => $this->getName(),
                'name_shortest' => $this->getShortestName(),
                'name_short' => $this->getShortName()
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
