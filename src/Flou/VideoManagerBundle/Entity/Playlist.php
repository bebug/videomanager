<?php

namespace Flou\VideoManagerBundle\Entity;

use Doctrine\ORM\Mapping\OneToOne;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Flou\VideoManagerBundle\Repository\PlaylistRepository")
 * @ORM\Table(name="flou_playlist")
 */
class Playlist
{
	public function __construct() {
		$this->videos = new \Doctrine\Common\Collections\ArrayCollection();
	}
	
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;
	
	/**
	 * @ORM\OneToOne(targetEntity="Title")
	 */
	private $title;
	
	/**
	 * @ORM\ManyToMany(targetEntity="Video", inversedBy="playlists")
	 * @ORM\JoinTable(name="flou_playlists_videos",
     *      joinColumns={@ORM\JoinColumn(name="playlist_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="video_id", referencedColumnName="id")}
     *      )
	 */
	private $videos;
	
	/**
	 * @ORM\ManyToOne(targetEntity="Channel", inversedBy="playlists")
	 * @ORM\JoinColumn(name="channel_id", referencedColumnName="id")
	 */
	private $channel;
	

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param Flou\VideoManagerBundle\Entity\Title $title
     */
    public function setTitle(\Flou\VideoManagerBundle\Entity\Title $title)
    {
        $this->title = $title;
    }

    /**
     * Get title
     *
     * @return Flou\VideoManagerBundle\Entity\Title 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Add videos
     *
     * @param Flou\VideoManagerBundle\Entity\Video $videos
     */
    public function addVideo(\Flou\VideoManagerBundle\Entity\Video $videos)
    {
    	$videos->addPlaylist($this);
        $this->videos[] = $videos;
    }

    /**
     * Get videos
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getVideos()
    {
        return $this->videos;
    }

    /**
     * Set channel
     *
     * @param Flou\VideoManagerBundle\Entity\Channel $channel
     */
    public function setChannel(\Flou\VideoManagerBundle\Entity\Channel $channel)
    {
        $this->channel = $channel;
    }

    /**
     * Get channel
     *
     * @return Flou\VideoManagerBundle\Entity\Channel 
     */
    public function getChannel()
    {
        return $this->channel;
    }

    /**
     * Remove videos
     *
     * @param Flou\VideoManagerBundle\Entity\Video $videos
     */
    public function removeVideo(\Flou\VideoManagerBundle\Entity\Video $videos)
    {
        $this->videos->removeElement($videos);
    }
}