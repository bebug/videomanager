<?php

namespace Flou\VideoWidgetBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Flou\VideoManagerBundle\Form\Type\TitleType;
use Flou\VideoManagerBundle\Form\Type\AbstractWidgetType;

use Doctrine\ORM\EntityRepository;

class LikebuttonWidgetType extends AbstractWidgetType
{
	public function __construct($channel_id)
	{
		parent::__construct($channel_id);
	}
	
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		parent::buildForm($builder, $options);
		$builder->add('google_enabled', 'checkbox', array(
				'label'     => 'Google+',
				'required'  => false,));
		$builder->add('facebook_enabled', 'checkbox', array(
				'label'     => 'Facebook',
				'required'  => false,));
		$builder->add('twitter_enabled', 'checkbox', array(
				'label'     => 'Twitter',
				'required'  => false,));
		$builder->add('bigsize', 'choice', array(
				'label'     => 'Größe',
				'choices'   => array(
        1   => 'Groß',
        0 => 'Klein',)));
	}
	
	public function getDefaultOptions(array $options)
	{
		return array(
				'data_class' => 'Flou\VideoWidgetBundle\Entity\LikebuttonWidget'
		);
	}

	public function getName()
	{
		return 'LikebuttonWidget';
	}
}