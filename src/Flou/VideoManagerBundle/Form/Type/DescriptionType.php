<?php

namespace Flou\VideoManagerBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Doctrine\ORM\EntityRepository;

class DescriptionType extends AbstractType
{
	
	public function __construct()
	{
	}
	
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('description_de', 'textarea', array(
				'label'     => 'Beschreibung Deutsch',
				'required'  => false,));
		$builder->add('description_en', 'textarea', array(
				'label'     => 'Beschreibung Englisch',
				'required'  => false,));
		$builder->add('description_fr', 'textarea', array(
				'label'     => 'Beschreibung Französisch',
				'required'  => false,));
	}
	
	public function getDefaultOptions(array $options)
	{
		return array(
				'data_class' => 'Flou\VideoManagerBundle\Entity\Description',
		);
	}

	public function getName()
	{
		return 'Description';
	}
}