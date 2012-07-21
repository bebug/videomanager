<?php

namespace Flou\VideoManagerBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * ChannelRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ChannelRepository extends EntityRepository
{
	public function findUnitedFirstByChannelId($id)
	{
		$query = $this->getEntityManager()
		->createQuery('
				SELECT	c.id,
				c.socialnetworks,
				c.showplaylist,
				c.header,
				c.menu,
				c.language_de,
				c.language_en,
				c.language_fr
				FROM FlouVideoManagerBundle:Channel c
				WHERE c.id = :id'
		)->setParameter('id', $id);
	
		return ($query->getSingleResult());
	}
}