<?php

namespace Flou\VideoManagerBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

use Doctrine\ORM\EntityRepository;

class ChannelHeadType extends AbstractType
{
	private $data;
	
	public function __construct()
	{
	}
	
	public function buildForm(FormBuilder $builder, array $options)
	{
		$builder->add('header', 'textarea', array(
				'label'     => 'Kopf',
				'required'  => false,));
		
	}
	
	public function getDefaultOptions(array $options)
	{
		return array(
				'data_class' => 'Flou\VideoManagerBundle\Entity\Channel',
		);
	}

	public function getName()
	{
		return 'Channel';
	}
}