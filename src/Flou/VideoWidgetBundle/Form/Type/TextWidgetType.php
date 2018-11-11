<?php

namespace Flou\VideoWidgetBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Flou\VideoManagerBundle\Form\Type\TitleType;
use Flou\VideoManagerBundle\Form\Type\DescriptionType;
use Flou\VideoManagerBundle\Form\Type\AbstractWidgetType;

use Doctrine\ORM\EntityRepository;

class TextWidgetType extends AbstractWidgetType
{	
	public function __construct($channel_id)
	{
		parent::__construct($channel_id);
	}
	
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		
		parent::buildForm($builder, $options);
		$builder->add('description', new DescriptionType());
		
	}
	
	public function getDefaultOptions(array $options)
	{
		return array(
				'data_class' => 'Flou\VideoWidgetBundle\Entity\TextWidget',
		);
	}

	public function getName()
	{
		return 'TextWidget';
	}
}