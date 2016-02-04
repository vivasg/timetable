<?php

namespace Dto;

use \Phalcon\Mvc\Model,
    Phalcon\Mvc\Model\Validator\PresenceOf,
    Phalcon\Mvc\Model\Validator\StringLength;

/**
 * Class Teacher
 * @package Dto
 *
 * @variable \Dto\Lesson $lessons
 */

class Teacher extends Model
{
	/**
	 * @var int
	 */
	private $id;

	/**
	 * @var string
	 */
	private $name_first;

	/**
	 * @var string
	 */
	private $name_last;

	/**
	 * @var string
	 */
	private $name_middle;

	/**
	 * @return string
	 */
	public function getNameFull()
	{
		return $this->name_last . ' ' . $this->name_first . ' ' . $this->name_middle;
	}

	/**
	 * @return string
	 */
	public function getNameShort()
	{
		$return = '';
		$return = $return . $this->name_last;
		if($this->name_first)
		{
			$return = $return . ' ' . mb_substr($this->name_first,0,2) . '.';
		}
		if($this->name_middle)
		{
			$return = $return . mb_substr($this->name_middle,0,2) . '.';
		}

		return $return;
		//return $this->name_last . ' ' . substr($this->name_first,0,2) . '.' . substr($this->name_middle,0,2) . '.';
	}

	/**
	 * @return int
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @return string
	 */
	public function getNameFirst()
	{
		return $this->name_first;
	}

	/**
	 * @return string
	 */
	public function getNameLast()
	{
		return $this->name_last;
	}

	/**
	 * @return string
	 */
	public function getNameMiddle()
	{
		return $this->name_middle;
	}

	/**
	 * @param int $value
	 *
	 * @return $this
	 */
	public function setId($value)
	{
		if(!is_int($value))
		{
			throw new \InvalidArgumentException('invalid type of argument: "id"');
		}
		if($value < 0)
		{
			throw new \OutOfRangeException('parameter "id" can not be less than 0');
		}

		$this->id = $value;
		return $this;
	}

	/**
	 * @param string|null $value
	 *
	 * @return $this
	 */
	public function setNameFirst($value)
	{
		if(!is_string($value))
		{
			throw new \InvalidArgumentException('invalid type of argument: "firstName"');
		}
		$this->name_first = $value;
		return $this;
	}

	/**
	 * @param string|null $value
	 *
	 * @return $this
	 */
	public function setNameLast($value)
	{
		if(!is_string($value))
		{
			throw new \InvalidArgumentException('invalid type of argument: "lastName"');
		}
		$this->name_last = $value;
		return $this;
	}

	/**
	 * @param string|null $value
	 *
	 * @return $this
	 */
	public function setNameMiddle($value)
	{
		if(!is_string($value))
		{
			throw new \InvalidArgumentException('invalid type of argument: "middleName"');
		}
		$this->name_middle = $value;
		return $this;
	}

	public function getSource()
	{
		return 'teachers';
	}

	public function initialize()
	{
		$this->hasMany('id', '\Dto\Lesson', 'teacher_id', [
			'alias' => 'lessons'
		]);
	}

	public function validation()
	{
		// Правила для name_first
		$this->validate(new PresenceOf([
			'field' => 'name_first',
			'message' => 'Not name_first in model',
		]));

		$this->validate(new StringLength([
			'field' => 'name_first',
			'max' => 255,
			'min' => 1,
			'messageMaximum' => 'name_first is to long',
			'messageMinimum' => 'name_first is to short',
		]));

		// Правила для name_last
		$this->validate(new PresenceOf([
			'field' => 'name_last',
			'message' => 'Not name_last in model',
		]));

		$this->validate(new StringLength([
			'field' => 'name_last',
			'max' => 255,
			'min' => 1,
			'messageMaximum' => 'name_last is to long',
			'messageMinimum' => 'name_last is to short',
		]));

		// Правила для name_middle
		$this->validate(new PresenceOf([
			'field' => 'name_middle',
			'message' => 'Not name_middle in model',
		]));

		$this->validate(new StringLength([
			'field' => 'name_middle',
			'max' => 255,
			'min' => 1,
			'messageMaximum' => 'name_middle is to long',
			'messageMinimum' => 'name_middle is to short',
		]));

		if ($this->validationHasFailed() == true)
		{
			return false;
		}

		return true;
	}

	/**
	 * @param array|null $parameters
	 */
	public function getLessons($parameters = null)
	{
		$this->getRelated('lessons', $parameters);
	}
}
