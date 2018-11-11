<?php

namespace Flou\VideoManagerBundle\Entity;

use Doctrine\ORM\Mapping\OneToOne;
use Flou\VideoManagerBundle\Repository;
use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;



/**
 * @ORM\Entity(repositoryClass="Flou\VideoManagerBundle\Repository\VideoRepository")
 * @ORM\Table(name="flou_video")
 */
class Video
{

	
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @Assert\File(maxSize="6000000")
     */
    public $file;
    
    /**
     * @ORM\ManyToOne(targetEntity="Channel", inversedBy="videos")
     */
    private $channel;
    
    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $s3key;
    
    /**
     * @ORM\Column(type="string", length=100,  nullable=true)
     */
    private $s3bucket;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $location;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $filename;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $rtmp;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $http;
    
    /**
     * @ORM\Column(type="string", length=9,  nullable=true)
     */
    private $duration;
    
    
    
    /**
     * @ORM\Column(type="boolean")
     */
    private $enabled;
    
    /**
     * @ORM\Column(type="datetime")
     */
    private $uploadtime;
    
    /**
     * @ORM\OneToOne(targetEntity="Description")
     */
    private $description;
    
    /**
     * @ORM\OneToOne(targetEntity="Description")
     */
    private $shortdescription;
    
    /**
     * @ORM\OneToOne(targetEntity="Title")
     */
    private $title;
    
    /**
     * @ORM\ManyToMany(targetEntity="Playlist", mappedBy="videos")
     **/
    private $playlists;
    
    function __toString()
    {
    	if($this->getTitle()->getTitleDe() == '')
    	{
    		return ' ';
    	}
    	else
    	{
    		return $this->getTitle()->getTitleDe();
    	}
    }

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
     * Set key
     *
     * @param string $key
     */
    public function setKey($key)
    {
        $this->key = $key;
    }

    /**
     * Get key
     *
     * @return string 
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Set enabled
     *
     * @param boolean $enabled
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
    }

    /**
     * Get enabled
     *
     * @return boolean 
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * Set uploadtime
     *
     * @param datetime $uploadtime
     */
    public function setUploadtime($uploadtime)
    {
        $this->uploadtime = $uploadtime;
    }

    /**
     * Get uploadtime
     *
     * @return datetime 
     */
    public function getUploadtime()
    {
        return $this->uploadtime;
    }

    /**
     * Set user
     *
     * @param Flou\VideoManagerBundle\Entity\User $user
     */
    public function setUser(\Flou\VideoManagerBundle\Entity\User $user)
    {
        $this->user = $user;
    }

    /**
     * Get user
     *
     * @return Flou\VideoManagerBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set location
     *
     * @param string $location
     */
    public function setLocation($location)
    {
        $this->location = $location;
    }

    /**
     * Get location
     *
     * @return string 
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Set s3key
     *
     * @param string $s3key
     */
    public function setS3key($s3key)
    {
        $this->s3key = $s3key;
    }

    /**
     * Get s3key
     *
     * @return string 
     */
    public function getS3key()
    {
        return $this->s3key;
    }

    /**
     * Set s3bucket
     *
     * @param string $s3bucket
     */
    public function setS3bucket($s3bucket)
    {
        $this->s3bucket = $s3bucket;
    }

    /**
     * Get s3bucket
     *
     * @return string 
     */
    public function getS3bucket()
    {
        return $this->s3bucket;
    }

    /**
     * Set description
     *
     * @param Flou\VideoManagerBundle\Entity\Description $description
     */
    public function setDescription(\Flou\VideoManagerBundle\Entity\Description $description)
    {
        $this->description = $description;
    }

    /**
     * Get description
     *
     * @return Flou\VideoManagerBundle\Entity\Description 
     */
    public function getDescription()
    {
        return $this->description;
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
     * Set rtmp
     *
     * @param string $rtmp
     */
    public function setRtmp($rtmp)
    {
        $this->rtmp = str_replace(' ', '%20', $rtmp);;
    }

    /**
     * Get rtmp
     *
     * @return string 
     */
    public function getRtmp()
    {
        return $this->rtmp;
    }

    /**
     * Set http
     *
     * @param string $http
     */
    public function setHttp($http)
    {
        $this->http = str_replace(' ', '%20', $http);
    }

    /**
     * Get http
     *
     * @return string 
     */
    public function getHttp()
    {
        return $this->http;
    }

    /**
     * Set filename
     *
     * @param string $filename
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;
    }

    /**
     * Get filename
     *
     * @return string 
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * Set duration
     *
     * @param string $duration
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;
    }

    /**
     * Get duration
     *
     * @return string 
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * Set shortdescription
     *
     * @param Flou\VideoManagerBundle\Entity\Description $shortdescription
     */
    public function setShortdescription(\Flou\VideoManagerBundle\Entity\Description $shortdescription)
    {
        $this->shortdescription = $shortdescription;
    }

    /**
     * Get shortdescription
     *
     * @return Flou\VideoManagerBundle\Entity\Description 
     */
    public function getShortdescription()
    {
        return $this->shortdescription;
    }
    public function __construct()
    {
        $this->playlists = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add playlists
     *
     * @param Flou\VideoManagerBundle\Entity\Playlist $playlists
     */
    public function addPlaylist(\Flou\VideoManagerBundle\Entity\Playlist $playlists)
    {
        $this->playlists[] = $playlists;
    }

    /**
     * Get playlists
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getPlaylists()
    {
        return $this->playlists;
    }

    /**
     * Remove playlists
     *
     * @param Flou\VideoManagerBundle\Entity\Playlist $playlists
     */
    public function removePlaylist(\Flou\VideoManagerBundle\Entity\Playlist $playlists)
    {
        $this->playlists->removeElement($playlists);
    }
}