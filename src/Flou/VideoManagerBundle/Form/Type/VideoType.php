<?php

namespace Flou\VideoManagerBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;


use Doctrine\ORM\EntityRepository;

class VideoType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('title', new TitleType());
		$builder->add('shortdescription', new ShortdescriptionType());
		$builder->add('description', new DescriptionType());
		$builder->add('enabled', 'checkbox', array(
				'label'     => 'Sichtbar',
				'required'  => false,));
	}
	
	public function getDefaultOptions(array $options)
	{
		return array(
				'data_class' => 'Flou\VideoManagerBundle\Entity\Video',
		);
	}

	public function getName()
	{
		return 'Video';
	}
}