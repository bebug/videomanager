<?php

namespace Flou\VideoManagerBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

use Doctrine\ORM\EntityRepository;

class PageType extends AbstractType
{
	
	public function __construct()
	{
	}
	
	public function buildForm(FormBuilder $builder, array $options)
	{
		
		$builder->add('pageposition', 'entity', array(
				'label'     => 'Ort',
				'class'		=> 'FlouVideoManagerBundle:Pageposition',
				'query_builder' => function(EntityRepository $er) {
				return $er->createQueryBuilder('u');
		
		},));
		
		$builder->add('orderrank', 'integer', array(
				'label'     => 'Anordnung',
				'required'  => false,));
		$builder->add('title', new TitleType());
		$builder->add('group', new GroupType());
		$builder->add('hyperlink', 'text', array(
				'label'     => 'Hyperlink',
				'max_length' => 100,
				'required'  => false,));
		$builder->add('description', new DescriptionType());
		//$builder->add('group', new DescriptionType());
		/*$builder->add('title', new TitleType());
		$builder->add('description', new DescriptionType());*/
		
	}
	
	public function getDefaultOptions(array $options)
	{
		return array(
				'data_class' => 'Flou\VideoManagerBundle\Entity\Page',
		);
	}

	public function getName()
	{
		return 'Page';
	}
}