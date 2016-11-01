<?php

namespace AppBundle\Validator\Constraints;

use AppBundle\Entity\Author;
use AppBundle\Entity\Book;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class BookCityValidator extends ConstraintValidator
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
			if ($author->getCityOfResidence() != $book->getCityOfIssue()){
				$message = 'The author\'s (' . $author->getFullName() . ') city of residence does not match with the city of issue';
				$context->buildViolation($message)->atPath('cityOfIssue')->addViolation();
				return;
			}
		}
	}
}