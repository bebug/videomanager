<?php

namespace Flou\VideoWidgetBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Flou\VideoManagerBundle\Form\Type\TitleType;
use Flou\VideoManagerBundle\Form\Type\AbstractWidgetType;

use Doctrine\ORM\EntityRepository;

class FbCommentWidgetType extends AbstractWidgetType
{
	public function __construct($channel_id)
	{
		parent::__construct($channel_id);
	}
	
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		parent::buildForm($builder, $options);
		$builder->add('dark', 'checkbox', array(
				'label'     => 'Dunkler Hintergrund',
				'required'  => false,));
	}
	
	public function getDefaultOptions(array $options)
	{
		return array(
				'data_class' => 'Flou\VideoWidgetBundle\Entity\FbCommentWidget'
		);
	}

	public function getName()
	{
		return 'FbCommentWidget';
	}
}