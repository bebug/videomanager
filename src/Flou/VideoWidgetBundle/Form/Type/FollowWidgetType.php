<?php

namespace Flou\VideoWidgetBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Flou\VideoManagerBundle\Form\Type\TitleType;
use Flou\VideoManagerBundle\Form\Type\AbstractWidgetType;

use Doctrine\ORM\EntityRepository;

class FollowWidgetType extends AbstractWidgetType
{
	public function __construct($channel_id)
	{
		parent::__construct($channel_id);
	}
	
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		parent::buildForm($builder, $options);
		
		$builder->add('googlelink', 'url', array(
				'label'     => 'Google',
				'max_length' => 100,
				'required'  => false,));
		$builder->add('xinglink', 'url', array(
				'label'     => 'Xing',
				'max_length' => 100,
				'required'  => false,));
		$builder->add('fblink', 'url', array(
				'label'     => 'Facebook',
				'max_length' => 100,
				'required'  => false,));
		$builder->add('twitterlink', 'url', array(
				'label'     => 'Twitter',
				'max_length' => 100,
				'required'  => false,));
		$builder->add('inlink', 'url', array(
				'label'     => 'LinkedIn',
				'max_length' => 100,
				'required'  => false,));
		$builder->add('ytlink', 'url', array(
				'label'     => 'Youtube',
				'max_length' => 100,
				'required'  => false,));
		
	}
	
	public function getDefaultOptions(array $options)
	{
		return array(
				'data_class' => 'Flou\VideoWidgetBundle\Entity\FollowWidget',
		);
	}

	public function getName()
	{
		return 'FollowWidget';
	}
}