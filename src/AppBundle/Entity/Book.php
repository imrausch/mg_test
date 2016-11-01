<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

class Book
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
	private $color;

	/**
	 * @var int
	 */
	private $yearOfIssue;

	/**
	 * @var string
	 */
	private $cityOfIssue;

	/**
	 * @var ArrayCollection
	 */
	private $authors;

	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->authors = new ArrayCollection();
	}

	/**
	 * @return integer
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @param string $name
	 * @return Event
	 */
	public function setName($name)
	{
		$this->name = $name;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * @param string $color
	 */
	public function setColor($color)
	{
		$this->color = $color;
	}

	/**
	 * @return string
	 */
	public function getColor()
	{
		return $this->color;
	}

	/**
	 * @param int $cityOfIssue
	 */
	public function setCityOfIssue($cityOfIssue)
	{
		$this->cityOfIssue = $cityOfIssue;
	}

	/**
	 * @return int
	 */
	public function getCityOfIssue()
	{
		return $this->cityOfIssue;
	}

	/**
	 * @param string $yearOfIssue
	 */
	public function setYearOfIssue($yearOfIssue)
	{
		$this->yearOfIssue = $yearOfIssue;
	}

	/**
	 * @return string
	 */
	public function getYearOfIssue()
	{
		return $this->yearOfIssue;
	}

	/**
	 * @param ArrayCollection $authors
	 */
	public function setAuthors($authors)
	{
		$this->authors = $authors;
	}

	/**
	 * @return ArrayCollection
	 */
	public function getAuthors()
	{
		return $this->authors;
	}
}
