<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookType extends AbstractType
{
	/**
	 * {@inheritdoc}
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('name');
		$builder->add('color');
		$builder->add('yearOfIssue');
		$builder->add('cityOfIssue');
		$builder->add('authors', 'entity', [
			'class' => 'AppBundle\Entity\Author',
			'multiple' => true,
			'choice_label' => 'surname',
			'expanded' => true,
		]);
	}

	/**
	 * {@inheritdoc}
	 */
	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults([
			'data_class' => 'AppBundle\Entity\Book',
		]);
	}

	/**
	 * {@inheritdoc}
	 */
	public function getName()
	{
		return 'book';
	}
}