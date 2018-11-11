<?php

namespace Flou\VideoManagerBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ContactType extends AbstractType
{	
	public function buildForm(FormBuilderInterface $builder, array $options)
	{

		$builder->add('from', 'email', array(
				'label'     => 'Email',
				'max_length' => 100,
				'required'  => true,));
		$builder->add('subject', 'text', array(
				'label'     => 'Betreff',
				'max_length' => 100,
				'required'  => true,));
		$builder->add('body', 'textarea', array(
				'label'     => 'Nachricht',
				'required'  => true,));
	}
	
	public function getDefaultOptions(array $options)
	{
		return array(
				'data_class' => 'Flou\VideoManagerBundle\Entity\Contact',
		);
	}

	public function getName()
	{
		return 'contact';
	}
}