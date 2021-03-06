<?php

namespace Flou\VideoManagerBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * PlaylistRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PlaylistRepository extends EntityRepository
{
	public function findUnitedListByChannelId($id, $language = 'de')
	{
		$query = $this->getEntityManager()
		->createQuery('
				SELECT	p.id,
				t.title_'.$language.' as title
				FROM FlouVideoManagerBundle:Playlist p
				JOIN p.title t
				JOIN p.channel c
				WHERE c.id = :id'
		)->setParameter('id', $id);
	
		return ($query->getResult());
	}
	
	public function findUnitedFirstByPlaylistId($id, $language = 'de')
	{
		$query = $this->getEntityManager()
		->createQuery('
				SELECT p.id,
				t.title_'.$language.' as title
				FROM FlouVideoManagerBundle:Playlist p
				JOIN p.title t
				WHERE p.id = :id'
		)->setParameter('id', $id);
	
		return ($query->getSingleResult());
	}
}