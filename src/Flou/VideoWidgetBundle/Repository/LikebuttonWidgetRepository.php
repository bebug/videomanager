<?php

namespace Flou\VideoWidgetBundle\Repository;
use Doctrine\ORM\EntityRepository;
use Flou\VideoManagerBundle\Repository\AbstractWidgetRepository;
/**
 * DesignRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class LikebuttonWidgetRepository extends AbstractWidgetRepository
{	
	protected function getNamespace(){
		return 'FlouVideoWidgetBundle:LikebuttonWidget';
	}
}