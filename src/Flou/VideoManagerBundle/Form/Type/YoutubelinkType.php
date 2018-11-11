<?php

namespace Flou\VideoManagerBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class YoutubelinkType extends AbstractType
{
	public function __construct()
	{
	}
	
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('link', 'text', array(
				'label'     => 'Youtube Video-ID',
				'max_length' => 11,
				'required'  => false,));
	}
	
	public function getDefaultOptions(array $options)
	{
		return array(
				'data_class' => 'Flou\VideoManagerBundle\Entity\Youtubelink',
		);
	}
	
	public function getName()
	{
		return 'Youtube';
	}
}