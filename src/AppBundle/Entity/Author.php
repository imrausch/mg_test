<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

class Author
{
	/**
	 * @var integer
	 */
	private $id;

	/**
	 * @var string
	 */
	private $name;

	/**
	 * @var string
	 */
	private $surname;

	/**
	 * @var int
	 */
	private $yearOfBirth;

	/**
	 * @var int
	 */
	private $yearOfDeath;

	/**
	 * @var string
	 */
	private $cityOfResidence;

	/**
	 * @var ArrayCollection
	 */
	private $books;

	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->books = new ArrayCollection();
	}

	/**
	 * @param int $id
	 */
	public function setId($id)
	{
		$this->id = $id;
	}

	/**
	 * @return int
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @param string $name
	 */
	public function setName($name)
	{
		$this->name = $name;
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * @param string $surname
	 */
	public function setSurname($surname)
	{
		$this->surname = $surname;
	}

	/**
	 * @return string
	 */
	public function getSurname()
	{
		return $this->surname;
	}

	/**
	 * @param int $yearOfBirth
	 */
	public function setYearOfBirth($yearOfBirth)
	{
		$this->yearOfBirth = $yearOfBirth;
	}

	/**
	 * @return int
	 */
	public function getYearOfBirth()
	{
		return $this->yearOfBirth;
	}

	/**
	 * @param int $yearOfDeath
	 */
	public function setYearOfDeath($yearOfDeath)
	{
		$this->yearOfDeath = $yearOfDeath;
	}

	/**
	 * @return int
	 */
	public function getYearOfDeath()
	{
		return $this->yearOfDeath;
	}

	/**
	 * @param string $cityOfResidence
	 */
	public function setCityOfResidence($cityOfResidence)
	{
		$this->cityOfResidence = $cityOfResidence;
	}

	/**
	 * @return string
	 */
	public function getCityOfResidence()
	{
		return $this->cityOfResidence;
	}

	/**
	 * @param ArrayCollection $books
	 */
	public function setBooks($books)
	{
		$this->books = $books;
	}

	/**
	 * @return ArrayCollection
	 */
	public function getBooks()
	{
		return $this->books;
	}

	/**
	 * @return string
	 */
	public function getFullName()
	{
		$parts = [];
		if ($this->surname){
			$parts[] = $this->surname;
		}
		if ($this->name){
			$parts[] = $this->name;
		}
		if ($this->yearOfDeath){
			$parts[] = '(' . $this->yearOfBirth . ' - ' . $this->yearOfDeath . ')';
		} else {
			$parts[] = '(' . $this->yearOfBirth . ')';
		}

		return implode(' ', $parts);
	}
}
