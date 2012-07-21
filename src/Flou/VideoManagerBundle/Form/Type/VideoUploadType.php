<?php

namespace Flou\VideoManagerBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;


use Doctrine\ORM\EntityRepository;

class VideoUploadType extends AbstractType
{
	public function buildForm(FormBuilder $builder, array $options)
	{
		$builder->add('file', 'file');
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