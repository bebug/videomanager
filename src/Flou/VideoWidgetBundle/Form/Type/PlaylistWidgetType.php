<?php

namespace Flou\VideoWidgetBundle\Form\Type;

use Flou\VideoWidgetBundle\Entity\PlaylistWidget;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Flou\VideoManagerBundle\Form\Type\TitleType;
use Flou\VideoManagerBundle\Form\Type\AbstractWidgetType;

use Doctrine\ORM\EntityRepository;

class PlaylistWidgetType extends AbstractWidgetType
{
	public function __construct($channel_id)
	{
		parent::__construct($channel_id);
	}
	
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		parent::buildForm($builder, $options);
		
		$builder->add('rendertype', 'choice', array(
				'choices'   => array(PlaylistWidget::VERTICAL => 'Vertical', PlaylistWidget::HORIZONTAL => 'Horizontal'),
				'label'     => 'Anzeigetyp',
				'multiple'  => false,
				'required'  => true,));
		$builder->add('bigsize', 'choice', array(
				'label'     => 'Größe',
				'choices'   => array(
						1   => 'Groß',
						0 => 'Klein',)));
		
	}
	
	public function getDefaultOptions(array $options)
	{
		return array(
				'data_class' => 'Flou\VideoWidgetBundle\Entity\PlaylistWidget',
		);
	}

	public function getName()
	{
		return 'PlaylistWidget';
	}
}