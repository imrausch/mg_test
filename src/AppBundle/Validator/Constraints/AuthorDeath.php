<?php

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

class AuthorDeath extends Constraint
{
	public function getTargets()
	{
		return self::CLASS_CONSTRAINT;
	}
}