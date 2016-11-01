<?php

namespace AppBundle\Utils;

use Symfony\Component\Form\Form;

class FormErrorsSerializer
{
	/**
	 * @param Form $form
	 * @return array
	 */
	public static function serializeErrors(Form $form)
	{
		$errors = [];
		foreach ($form->getErrors() as $error) {
			/** @var \Symfony\Component\Form\FormError $error */
			$errors['errors'][] = $error->getMessage();
		}
		if ($form->count() > 0) {
			$fieldErrors = [];
			foreach ($form->all() as $child) {
				/** @var Form $child */
				if (!$child->isValid()) {
					$fieldErrors[$child->getName()] = self::serializeErrors($child);
				}
			}
			$errors['fields'] = $fieldErrors;
		}
		return $errors;
	}
}