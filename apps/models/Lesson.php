<?php

use \Dto\Lesson as Dto,
    \Phalcon\Mvc\Model\Resultset\Simple;

class Lesson
{
    /**
     * @var \Dto\Lesson
     */
    private $dto;

    const MAX_LESSON_NUMBER = '13';
    const MIN_LESSON_NUMBER = '0';

    /**
     * Get id
     *
     * @return int
     */
    public function getTeacherId()
    {
        return $this->dto->getTeacherId();
    }

    /**
     * Set Teacher id
     *
     * @param int $teacherId
     * @return $this
     */
    public function setTeacherId($teacherId)
    {
        $this->dto->setTeacherId($teacherId);
        return $this;
    }

    /**
     * Get School Room id
     *
     * @return int
     */
    public function getSchoolRoomId()
    {
        return $this->dto->getSchoolRoomId();
    }

    /**
     * Set School Room id
     *
     * @param int $schoolRoomId
     * @return $this
     */
    public function setSchoolRoomId($schoolRoomId)
    {
        $this->dto->setSchoolRoomId($schoolRoomId);
        return $this;
    }

    /**
     * Get Subject id
     *
     * @return int
     */
    public function getSubjectId()
    {
        return $this->dto->getSubjectId();
    }

    /**
     * Set Subject id
     *
     * @param int $subjectId
     * @return $this
     */
    public function setSubjectId($subjectId)
    {
        $this->dto->setSubjectId($subjectId);
        return $this;
    }

    /**
     * Get School Class id
     *
     * @return int
     */
    public function getSchoolClassId()
    {
        return $this->dto->getSchoolClassId();
    }

    /**
     * Set School Class id
     *
     * @param int $schoolClassId
     * @return $this
     */
    public function setSchoolClassId($schoolClassId)
    {
        $this->dto->setSchoolClassId($schoolClassId);
        return $this;
    }

    /**
     * Get Lesson Day id
     *
     * @return int
     */
    public function getLessonDayId()
    {
        return $this->dto->getLessonDayId();
    }

    /**
     * Set Lesson Day id
     *
     * @param int $lessonDayId
     * @return $this
     */
    public function setLessonDayId($lessonDayId)
    {
        $this->dto->setLessonDayId($lessonDayId);
        return $this;
    }

    /**
     * Get id by Lesson
     *
     * @return int
     */
    public function getId()
    {
        return $this->dto->getId();
    }

    /**
     * Set id by Lesson
     *
     * @param int $id
     * @return $this
     */
    public function setId($id)
    {
        $this->dto->setId($id);
        return $this;
    }

    /**
     * Get Lesson Day
     *
     * @return LessonDay
     */
    public function getLessonDay()
    {
        if($this->dto->getLessonDay())
        {
            return new \LessonDay ($this->dto->getLessonDay());
        }
        return null;
    }

    /**
     * Set Lesson Day
     *
     * @param LessonDay $lessonDay
     * @return $this
     */
    public function setLessonDay($lessonDay)
    {
        $this->dto->setLessonDay($lessonDay);
        return $this;
    }

    /**
     * Get Lesson Number
     *
     * @return int
     */
    public function getLessonNumber()
    {
        if($this->dto->getLessonNumber())
        {
            return $this->dto->getLessonNumber();
        }
        return null;
    }

    /**
     * Set Lesson Number
     *
     * @param int $lessonNumber
     * @return $this
     */
    public function setLessonNumber($lessonNumber)
    {
        if($lessonNumber < self::MIN_LESSON_NUMBER || $lessonNumber > self::MAX_LESSON_NUMBER)
        {
            throw new \OutOfRangeException('parameter "lessonNumber" can not be less than' . self::MIN_LESSON_NUMBER . 'ot greater than' . self::MAX_LESSON_NUMBER);
        }
        $this->dto->setLessonNumber($lessonNumber);
        return $this;
    }

    /**
     * Get School Class
     *
     * @return SchoolClass
     */
    public function getSchoolClass()
    {
        if($this->dto->getSchoolClass())
        {
            return new \SchoolClass($this->dto->getSchoolClass());
        }
        return null;
    }

    /**
     * Set School Class
     *
     * @param SchoolClass $schoolClass
     * @return $this
     */
    public function setSchoolClass($schoolClass)
    {
        $this->dto->setSchoolClass($schoolClass);
        return $this;
    }

    /**
     * Get School Room
     *
     * @return SchoolRoom
     */
    public function getSchoolRoom()
    {
        if($this->dto->getSchoolRoom())
        {
            return new \SchoolRoom($this->dto->getSchoolRoom());
        }
        return null;
    }

    /**
     * Set School Room
     *
     * @param SchoolRoom $schoolRoom
     * @return $this
     */
    public function setSchoolRoom($schoolRoom)
    {
        $this->dto->setSchoolRoom($schoolRoom);
        return $this;
    }

    /**
     * Get Subject
     *
     * @return Subject
     */
    public function getSubject()
    {
        if($this->dto->getSubject())
        {
            return new \Subject($this->dto->getSubject());
        }
        return null;
    }

    /**
     * Set Subject
     *
     * @param Subject $subject
     * @return $this
     */
    public function setSubject($subject)
    {
        $this->dto->setSubject($subject);
        return $this;
    }

    /**
     * Get Teacher
     *
     * @return Teacher
     */
    public function getTeacher()
    {
        if($this->dto->getTeacher())
        {
            return new \Teacher($this->dto->getTeacher());
        }
        return null;
    }

    /**
     * Set Teacher
     *
     * @param Teacher $teacher
     * @return $this;
     */
    public function setTeacher($teacher)
    {
        $this->dto->setTeacher($teacher);
        return $this;
    }

    public function __construct(Dto $dto = null)
    {
        if(is_null($dto))
        {
            $dto = new Dto();
        }
        $this->dto = $dto;

    }

    /**find all Lessons
     * @return array|null
     */
    public static function find()
    {
        return  Lesson::getMany(null);
    }

    /** find Lesson by id
     * @param int $id
     * @return Lesson|null
     */
    public static function findById($id)
    {
        $parameters = [
            'conditions' => 'id=:id:',
            'bind' => [
                'id' => $id
            ],
        ];
        return Lesson::getOne($parameters);
    }

    /**find Lessons by Lesson Day id
     * @param int $lessonDayId
     * @return array|null
     */
    public static function findByLessonDayId($lessonDayId)
    {
            $parameters = [
                'conditions' => 'lesson_day_id=:id:',
                'bind' => [
                    'id' => $lessonDayId
                ],
            ];
            return Lesson::getMany($parameters);
    }

    /**find Lessons by School Room id
     * @param int $schoolRoomId
     * @return array|null
     */
    public static function findBySchoolRoomId($schoolRoomId)
    {
        $parameters = [
            'conditions' => 'lesson_day_id=:id:',
            'bind' => [
                'id' => $schoolRoomId
            ],
        ];
        return Lesson::getMany($parameters);
    }

    /**find by Lessons Subject id
     * @param int $subjectId
     * @return array|null
     */
    public static function findBySubjectId($subjectId)
    {
        $parameters = [
            'conditions' => 'subject_id=:id:',
            'bind' => [
                'id' => $subjectId
            ],
        ];
        return Lesson::getMany($parameters);
    }
    /**find Lessons by Teacher id
     * @param int $teacherId
     * @return Lesson
     */
    public static function findByTeacherId($teacherId)
    {
        $parameters = [
            'conditions' => 'teacher_id=:teacher_id:',
            'bind' => [
                'teacher_id' => $teacherId
            ],
        ];
        return Lesson::getMany($parameters);
    }

     /** Return an array of the selected items
     * @param $parameters
     * @return array|null
     */
    public static function getMany($parameters = null)
    {
        /** @var Simple $tmp_lesson */
        $tmp_lessons = Dto::find($parameters);
        if ($tmp_lessons instanceof Simple && $tmp_lessons->count() > 0)
        {
            $return = [];

            /** @var Dto $tmp_lesson */
            foreach ($tmp_lessons as $tmp_lesson)
            {
                $return[] = new Lesson($tmp_lesson);
            }
            //echo $tmp_lessons->count();
            return $return;
        }
        return null;
    }

    /** Return an element of the selected item
     * @param $parameters
     * @return Lesson|null
     */
    public static function getOne($parameters)
    {
        /** @var Dto $tmp_lesson */
        $tmp_lesson = Dto::findFirst($parameters);
        if ($tmp_lesson instanceof Dto)
        {
            return new Lesson($tmp_lesson);
        }
        return null;
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

    public function GetResponseData()
    {
        $data[] = [
            'type' => 'Lesson',
            'id' => $this->getId(),
            'attributes' => [
                'lesson_day' => !$this->getLessonDay()? '' :$this->getLessonDay()->GetResponseData(),
                'lesson_number' => !$this->getLessonNumber()? '' : $this->getLessonNumber(),
                'school_class' => !$this->getSchoolClass()? '' : $this->getSchoolClass()->GetResponseData(),
                'subject' => !$this->getSubject()? '' : $this->getSubject()->GetResponseData(),
                'school_room' => !$this->getSchoolRoom()? '' : $this->getSchoolRoom()->getResponseData(),
                'teacher' => !$this->getTeacher()? '' : $this->getTeacher()->GetResponseData(),
            ],
        ];
        return $data;
    }
}
