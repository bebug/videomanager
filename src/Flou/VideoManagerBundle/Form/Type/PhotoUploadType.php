<?php

namespace Flou\VideoManagerBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class PhotoUploadType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('file', 'file', array(
				'label'     => 'Datei',
				'required'  => true,));
		$builder->add('orderrank', 'integer', array(
				'label'     => 'Anordnung',
				'required'  => true,));
		$builder->add('title', new TitleType());
		$builder->add('description', new DescriptionType());
	}
	
	public function getDefaultOptions(array $options)
	{
		return array(
				'data_class' => 'Flou\VideoManagerBundle\Entity\PhotoUpload',
		);
	}

	public function getName()
	{
		return 'Foto';
	}
}