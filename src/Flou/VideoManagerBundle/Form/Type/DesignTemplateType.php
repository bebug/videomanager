<?php

namespace Flou\VideoManagerBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Doctrine\ORM\EntityRepository;

class DesignTemplateType extends AbstractType
{
	
	public function __construct()
	{
	}
	
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		
		$builder->add('template', 'entity', array(
				'label'     => 'Design',
				'class'		=> 'FlouVideoManagerBundle:Template',
				'required'  => true,
				'query_builder' => function(EntityRepository $er) {
        			return $er->createQueryBuilder('u');
    			},));
    	$builder->add('usertemplate', 'textarea', array(
    					'label'     => 'Template',
    					'required'  => false,));
    	$builder->add('head', 'textarea', array(
    			'label'     => 'HTML-Head',
    			'required'  => false,));
	}
	
	public function getDefaultOptions(array $options)
	{
		return array(
				'data_class' => 'Flou\VideoManagerBundle\Entity\Design',
		);
	}

	public function getName()
	{
		return 'Design';
	}
}