<?php

namespace AppBundle\Validator\Constraints;

use AppBundle\Entity\Author;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class AuthorYearsValidator extends ConstraintValidator
{
	/**
	 * @param Author $author
	 * @param Constraint $constraint
	 */
	public function validate($author, Constraint $constraint)
	{
		/** @var \Symfony\Component\Validator\Context\ExecutionContext $context */
		$context = $this->context;

		$now = new \DateTime();
		$year = (int)$now->format('Y');
		if ($author->getYearOfBirth() > $year){
			$message = 'The year of the author\'s (' . $author->getFullName() . ') birth is greater than the current year';
			$context->buildViolation($message)->atPath('yearOfBirth')->addViolation();
			return;
		}
		if ($author->getYearOfDeath() && $author->getYearOfDeath() > $year){
			$message = 'The year of the author\'s (' . $author->getFullName() . ') death is greater than the current year';
			$context->buildViolation($message)->atPath('yearOfDeath')->addViolation();
			return;
		}
		if ($author->getYearOfDeath() && $author->getYearOfDeath() < $author->getYearOfBirth()){
			$message = 'The year of the author\'s (' . $author->getFullName() . ') birth is greater than the year of his death';
			$context->buildViolation($message)->atPath('yearOfDeath')->addViolation();
			return;
		}
	}

}