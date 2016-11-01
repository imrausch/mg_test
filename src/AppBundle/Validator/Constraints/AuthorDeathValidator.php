<?php

namespace AppBundle\Validator\Constraints;

use AppBundle\Entity\Author;
use AppBundle\Entity\Book;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class AuthorDeathValidator extends ConstraintValidator
{
	/**
	 * @param Book $book
	 * @param Constraint $constraint
	 */
	public function validate($book, Constraint $constraint)
	{
		/** @var \Symfony\Component\Validator\Context\ExecutionContext $context */
		$context = $this->context;

		foreach ($book->getAuthors() as $author){
			/** @var Author $author */
			$now = new \DateTime();
			$year = (int) $now->format('Y');
			if ($author->getYearOfDeath() && $year - $author->getYearOfDeath() < 100){
				$message = 'The current year exceeds the year of the author\'s death (' . $author->getFullName() . ') less than 100 years';
				$context->buildViolation($message)->atPath('authors')->addViolation();
				return;
			}
		}
	}
}