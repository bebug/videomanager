<?php

namespace Flou\VideoManagerBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Doctrine\ORM\EntityRepository;

class DesignColorType extends AbstractType
{
	
	public function __construct()
	{
	}
	
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('font', 'entity', array(
				'label'     => 'Schriftart',
				'class'		=> 'FlouVideoManagerBundle:Font',
				'required'  => true,
				'query_builder' => function(EntityRepository $er) {
        			return $er->createQueryBuilder('u');
        				//->where('u.$channel = ?', $options['$channel'])
						//->orderBy('u.title', 'ASC');
    			},));
    	$builder->add('headingfont', 'entity', array(
    			'label'     => 'Schriftart Überschrift',
    			'class'		=> 'FlouVideoManagerBundle:Font',
    			'required'  => true,
    			'query_builder' => function(EntityRepository $er) {
    				return $er->createQueryBuilder('u');
    			},));
    
    	$builder->add('headingcolor', 'text', array(
    			'label'     => 'Farbe Überschrift',
    			'max_length' => 6,
    			'required'  => false,));
		$builder->add('color1', 'text', array(
				'label'     => 'Farbe 1',
				'max_length' => 6,
				'required'  => false,));
		$builder->add('color2', 'text', array(
				'label'     => 'Farbe 2',
				'max_length' => 6,
				'required'  => false,));
		$builder->add('color3', 'text', array(
				'label'     => 'Farbe 3',
				'max_length' => 6,
				'required'  => false,));
		$builder->add('hovercolor1', 'text', array(
				'label'     => 'Hover-Farbe 1',
				'max_length' => 6,
				'required'  => false,));
		$builder->add('hovercolor2', 'text', array(
				'label'     => 'Hover-Farbe 2',
				'max_length' => 6,
				'required'  => false,));
		$builder->add('hovercolor3', 'text', array(
				'label'     => 'Hover-Farbe 3',
				'max_length' => 6,
				'required'  => false,));
		$builder->add('fontcolor1', 'text', array(
				'label'     => 'Schriftfarbe 1',
				'max_length' => 6,
				'required'  => false,));
		$builder->add('fontcolor2', 'text', array(
				'label'     => 'Schriftfarbe 2',
				'max_length' => 6,
				'required'  => false,));
		$builder->add('fontcolor3', 'text', array(
				'label'     => 'Schriftfarbe 3',
				'max_length' => 6,
				'required'  => false,));
		$builder->add('hoverfontcolor1', 'text', array(
				'label'     => 'Hover-Schriftfarbe 1',
				'max_length' => 6,
				'required'  => false,));
		$builder->add('hoverfontcolor2', 'text', array(
				'label'     => 'Hover-Schriftfarbe 2',
				'max_length' => 6,
				'required'  => false,));
		$builder->add('hoverfontcolor3', 'text', array(
				'label'     => 'Hover-Schriftfarbe 3',
				'max_length' => 6,
				'required'  => false,));
		$builder->add('linkcolor1', 'text', array(
				'label'     => 'Linkfarbe 1',
				'max_length' => 6,
				'required'  => false,));
		$builder->add('linkcolor2', 'text', array(
				'label'     => 'Linkfarbe 2',
				'max_length' => 6,
				'required'  => false,));
		$builder->add('linkcolor3', 'text', array(
				'label'     => 'Linkfarbe 3',
				'max_length' => 6,
				'required'  => false,));
		$builder->add('hoverlinkcolor1', 'text', array(
				'label'     => 'Hover-Linkfarbe 1',
				'max_length' => 6,
				'required'  => false,));
		$builder->add('hoverlinkcolor2', 'text', array(
				'label'     => 'Hover-Linkfarbe 2',
				'max_length' => 6,
				'required'  => false,));
		$builder->add('hoverlinkcolor3', 'text', array(
				'label'     => 'Hover-Linkfarbe 3',
				'max_length' => 6,
				'required'  => false,));
		$builder->add('fontsize', 'integer', array(
				'label'     => 'Schriftgröße',
				'required'  => true,));
	}
	
	public function getDefaultOptions(array $options)
	{
		return array(
				'data_class' => 'Flou\VideoManagerBundle\Entity\Design',
		);
	}

	public function getName()
	{
		return 'Design';
	}
}