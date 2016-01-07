<?php

namespace Dto;

use \Phalcon\Mvc\Model,
    Phalcon\Mvc\Model\Validator\PresenceOf,
    Phalcon\Mvc\Model\Validator\StringLength;

/**
 * Class Teacher
 * @package Dto
 *
 * @variable \Dto\Lesson lessons
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
		return $this->name_first+" "+$this->name_middle+" "+$this->name_last;
	}

	/**
	 * @return string
	 */
	public function getNameShort()
	{
		return $this->name_first+" "+$this->name_middle[0]+" "+$this->name_last[0];
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
		$this->name_middle = $value;
		return $this;
	}

	public function initialize()
	{
		$this->hasMany('id', '\Dto\Lesson', 'teacher_id', [
			'alias' => 'lessons'
		]);
	}

	public function validation()
	{
		// Правила для id
		$this->validate(new PresenceOf([
			'field' => 'id',
			'message' => 'Not id in model',
		]));

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
	}

	/**
	 * @param array|null $parameters
	 */
	public function getLessons($parameters = null)
	{
		$this->getRelated('lessons', $parameters);
	}
}
