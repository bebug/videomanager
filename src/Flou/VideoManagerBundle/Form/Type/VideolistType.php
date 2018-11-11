<?php

namespace Flou\VideoManagerBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;


use Doctrine\ORM\EntityRepository;

class VideolistType extends AbstractType
{
	public $channel_id;
	
	public function __construct($channel_id)
	{
		$this->channel_id = $channel_id;
	}
	
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$channel_id = $this->channel_id;
	
		$builder->add('videochoice', 'entity', array(
				'label'     => 'Video',
				'empty_value' => false,
				'required'  => true,
				'query_builder' => function(EntityRepository $er) use ($channel_id) {
				return $er->createQueryBuilder()
				->select('u')->from('FlouVideoManagerBundle:Design', 'u')
				->leftJoin('u.channel', 'c')
				->where('c.id = '.$channel_id);
		},));
	}
	
	public function getDefaultOptions(array $options)
	{
		return array(
				'data_class' => 'Flou\VideoManagerBundle\Entity\Video',
		);
	}
	
	public function getName()
	{
		return 'Videolist';
	}
}