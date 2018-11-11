<?php

namespace Flou\VideoManagerBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Doctrine\ORM\EntityRepository;

class ChannelType extends AbstractType
{
	public $channel_id;
	
	public function __construct($channel_id = 0)
	{
		$this->channel_id = $channel_id;
	}
	
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$channel_id = $this->channel_id;
		
		$builder->add('channelname', 'text', array(
				'label'     => 'Kanal-Name',
				'max_length' => 100,
				'required'  => false,));
		$builder->add('fbid', 'text', array(
				'label'     => 'Facebook-App-Id',
				'max_length' => 100,
				'required'  => false,));
		$builder->add('contactemail', 'email', array(
				'label'     => 'Kontakt E-Mail',
				'max_length' => 100,
				'required'  => false,));
		$builder->add('language_de', 'checkbox', array(
				'label'     => 'Deutsch',
				'required'  => false,));
		$builder->add('language_en', 'checkbox', array(
				'label'     => 'Englisch',
				'required'  => false,));
		$builder->add('language_fr', 'checkbox', array(
				'label'     => 'Französisch',
				'required'  => false,));
		$builder->add('use_html5', 'checkbox', array(
				'label'     => 'HTML5-Streaming benutzen',
				'required'  => false,));
		$builder->add('use_hyphernate', 'checkbox', array(
				'label'     => 'Automatische Silbentrennung',
				'required'  => false,));
		$builder->add('defaultpage', 'entity', array(
				'label'     => 'Startseite',
				'empty_value' => 'TV',
				'class'		=> 'FlouVideoManagerBundle:Page',
				'required'  => false,
				'query_builder' => function(EntityRepository $er) use ($channel_id) {
        			return $er->createQueryBuilder('u')
        					->select('u')
        					->leftJoin('u.channel', 'c')
        					->where('c.id = '.$channel_id);
    			},));
	}
	
	public function getDefaultOptions(array $options)
	{
		return array(
				'data_class' => 'Flou\VideoManagerBundle\Entity\Channel',
		);
	}

	public function getName()
	{
		return 'Channel';
	}
}