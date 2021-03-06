<?php

namespace Flou\VideoManagerBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ZipFileType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('file', 'file', array(
				'label'     => 'Datei',
				'required'  => true,));
	}
	
	public function getDefaultOptions(array $options)
	{
		return array(
				'data_class' => 'Flou\VideoManagerBundle\Entity\ZipFile',
		);
	}

	public function getName()
	{
		return 'ZipFile';
	}
}