<?php

namespace AppBundle\Utils;

use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class ViolationListMessagesSerializer
{
	/**
	 * @param ConstraintViolationListInterface $violationList
	 * @return array
	 */
	public static function serializeMessages(ConstraintViolationListInterface $violationList)
	{
		$errors = [];
		foreach ($violationList as $violation){
			/** @var ConstraintViolationInterface $violation */
			if (!$violation->getPropertyPath()){
				$errors['errors'][] = $violation->getMessage();
			} else {
				$errors['fields'][$violation->getPropertyPath()]['errors'][] = $violation->getMessage();
			}
		}
		return $errors;
	}
}