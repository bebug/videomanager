<?php

namespace Flou\VideoManagerBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class PhotoType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('orderrank', 'integer', array(
				'label'     => 'Anordnung',
				'required'  => false,));
		$builder->add('title', new TitleType());
		$builder->add('description', new DescriptionType());
	}
	
	public function getDefaultOptions(array $options)
	{
		return array(
				'data_class' => 'Flou\VideoManagerBundle\Entity\Photo',
		);
	}

	public function getName()
	{
		return 'Foto';
	}
}