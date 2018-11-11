<?php

namespace Flou\VideoManagerBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Doctrine\ORM\EntityRepository;

class AbstractWidgetType extends AbstractType
{
	private $channel_id;
	
	public function __construct($channel_id = 0)
	{
		$this->channel_id = $channel_id;
	}
	
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$channel_id = $this->channel_id;
		
		$builder->add('position', 'entity', array(
				'label'     => 'Ort',
				'class'		=> 'FlouVideoManagerBundle:Pageposition',
				'query_builder' => function(EntityRepository $er) {
				return $er->createQueryBuilder('u');
		
		},));
		$builder->add('orderrank', 'integer', array(
				'label'     => 'Anordnung',
				'required'  => false,));
		
		$builder->add('showonpage', 'checkbox', array(
				'label'     => 'Auf Seiten sichtbar',
				'required'  => false,));
		$builder->add('showonvideo', 'checkbox', array(
				'label'     => 'Auf Videos sichtbar',
				'required'  => false,));
		
		$builder->add('title', new TitleType());
		$builder->add('page', 'entity', array(
				'label'     => utf8_encode('Seitenbeschränkung'),
				'empty_value' => 'Alle Seiten',
				'class'		=> 'FlouVideoManagerBundle:Page',
				'required'  => false,
				'query_builder' => function(EntityRepository $er) use ($channel_id) {
				return $er->createQueryBuilder('u')
				->select('u')
				->leftJoin('u.channel', 'c')
				->leftJoin('u.title', 't')
				->where('c.id = '.$channel_id);
		},));
	}
	
	public function getDefaultOptions(array $options)
	{
		return array(
				'data_class' => 'Flou\VideoManagerBundle\Entity\AbstractWidget',
		);
	}

	public function getName()
	{
		return 'AbstractWidget';
	}
}