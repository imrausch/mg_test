<?php

namespace AppBundle\Validator\Constraints;

use AppBundle\Entity\Author;
use AppBundle\Entity\Book;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class BookYearValidator extends ConstraintValidator
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
			if ($author->getYearOfBirth() > $book->getYearOfIssue()){
				$message = 'The year of the author\'s (' . $author->getFullName() . ') birth is greater than the year of issue of the book';
				$context->buildViolation($message)->atPath('yearOfIssue')->addViolation();
				return;
			}
			if ($author->getYearOfDeath() && $book->getYearOfIssue() > $author->getYearOfDeath() && $book->getYearOfIssue() - $author->getYearOfDeath() < 70){
				$message = 'The year of issue of the book exceeds the year of the author\'s (' . $author->getFullName() . ') death for less than 70 years';
				$context->buildViolation($message)->atPath('yearOfIssue')->addViolation();
				return;
			}
		}
	}
}