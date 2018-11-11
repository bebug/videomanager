<?php

namespace Flou\VideoWidgetBundle\Repository;

use Flou\VideoManagerBundle\Entity\Description;
use Flou\VideoManagerBundle\Entity\Title;
use Doctrine\ORM\EntityRepository;
use Flou\VideoManagerBundle\Repository\AbstractWidgetRepository;
/**
 * DesignRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TextWidgetRepository extends AbstractWidgetRepository
{
	protected function getNamespace(){
		return 'FlouVideoWidgetBundle:TextWidget';
	}
	
	protected function getAdditionalJoin(){
		return 'JOIN widget.description des';
	}
	
	protected function getAdditionalSelect(){
		return ' des,  ';
	}
}