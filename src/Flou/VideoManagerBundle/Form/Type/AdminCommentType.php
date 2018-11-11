<?php

namespace Flou\VideoManagerBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class AdminCommentType extends AbstractType
{
	
	public function __construct()
	{
	}
	
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
	    $builder->add('message', 'textarea', array(
    			'label'     => 'Begründung',
    			'required'  => true,));
	    $builder->add('name', 'text', array(
	    		'label'     => 'Vollständiger Name',
	    		'required'  => true,));
	}
	
	public function getDefaultOptions(array $options)
	{
		return array(
				'data_class' => 'Flou\VideoManagerBundle\Entity\AdminComment',
		);
	}

	public function getName()
	{
		return 'AdminComment';
	}
}