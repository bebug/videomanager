<?php

namespace Flou\VideoManagerBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

use Doctrine\ORM\EntityRepository;

class ChannelMenuType extends AbstractType
{
	private $data;
	
	public function __construct()
	{
	}
	
	public function buildForm(FormBuilder $builder, array $options)
	{
		$builder->add('menu', 'textarea', array(
				'label'     => 'Menu',
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