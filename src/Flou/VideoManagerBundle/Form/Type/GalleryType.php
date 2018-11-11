<?php

namespace Flou\VideoManagerBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Doctrine\ORM\EntityRepository;

class GalleryType extends AbstractType
{
	public function __construct()
	{
	}
	
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('title', new TitleType());
	}
	
	public function getDefaultOptions(array $options)
	{
		return array(
				'data_class' => 'Flou\VideoManagerBundle\Entity\Gallery',
		);
	}
	
	public function getName()
	{
		return 'Gallery';
	}
}