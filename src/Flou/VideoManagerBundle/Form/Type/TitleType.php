<?php

namespace Flou\VideoManagerBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

use Doctrine\ORM\EntityRepository;

class TitleType extends AbstractType
{
	
	public function __construct()
	{
	}
	
	public function buildForm(FormBuilder $builder, array $options)
	{
		$builder->add('title_de', 'text', array(
				'label'     => 'Name',
				'max_length' => 100,
				'required'  => false,));
		$builder->add('title_en', 'text', array(
				'label'     => 'Name',
				'max_length' => 100,
				'required'  => false,));
		$builder->add('title_fr', 'text', array(
				'label'     => 'Name',
				'max_length' => 100,
				'required'  => false,));
	}
	
	public function getDefaultOptions(array $options)
	{
		return array(
				'data_class' => 'Flou\VideoManagerBundle\Entity\Title',
		);
	}

	public function getName()
	{
		return 'Title';
	}
}