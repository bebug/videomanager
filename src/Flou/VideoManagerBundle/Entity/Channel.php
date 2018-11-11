<?php

namespace Flou\VideoManagerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Flou\VideoManagerBundle\Repository\ChannelRepository")
 * @ORM\Table(name="flou_channel")
 * @ORM\HasLifecycleCallbacks
 */
class Channel
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="User", mappedBy="channel")
     */
    private $user;
    
    /**
     * @ORM\OneToMany(targetEntity="Video", mappedBy="channel")
     *
     */
    private $videos;
    
    /**
     * @ORM\OneToMany(targetEntity="Page", mappedBy="channel", cascade={"all"})
     *
     */
    private $pages;
    
    /**
     * @ORM\OneToMany(targetEntity="Playlist", mappedBy="channel", cascade={"all"})
     *
     */
    private $playlists;
    
    /**
     * @ORM\OneToMany(targetEntity="Gallery", mappedBy="channel", cascade={"all"})
     *
     */
    private $galleries;
    
    /**
     * @ORM\OneToOne(targetEntity="Page")
     * @ORM\JoinColumn(name="defaultpage_id", referencedColumnName="id", nullable=true)
     *
     */
    private $defaultpage;
    
    /**
     * @ORM\OneToOne(targetEntity="Design", inversedBy="channel")
     *
     */
    private $design;
  
    /**
     * @ORM\Column(type="boolean")
     */
    private $language_en;
    
    /**
     * @ORM\Column(type="boolean")
     */
    private $language_fr;
    
    /**
     * @ORM\Column(type="boolean")
     */
    private $language_de;
    
    /**
     * @ORM\Column(type="string", length=100,  nullable=true)
     */
    private $fbid;
    
    /**
     * @ORM\Column(type="string", length=100,  nullable=true)
     */
    private $channelname;
    
    /**
     * @ORM\Column(type="string", length=100,  nullable=true)
     */
    private $s3bucket;
    
    /**
     * @ORM\Column(type="string", length=100,  nullable=true)
     */
    private $streamdistribution;
    
    /**
     * @ORM\Column(type="string", length=100,  nullable=true)
     */
    private $downloaddistribution;
    
    /**
     * @ORM\Column(type="string", length=100,  nullable=true)
     */
    private $contactemail;
    
    /**
     * @ORM\Column(type="boolean")
     */
    private $playlist_enabled;
    
    /**
     * @ORM\Column(type="integer")
     */
    private $max_videos;
    
    /**
     * @ORM\Column(type="integer")
     */
    private $piwikid;
    
    /**
     * @ORM\Column(type="boolean")
     */
    private $use_html5;
    
    /**
     * @ORM\Column(type="boolean")
     */
    private $use_hyphernate;
    
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
     * Set socialnetworks
     *
     * @param boolean $socialnetworks
     */
    public function setSocialnetworks($socialnetworks)
    {
        $this->socialnetworks = $socialnetworks;
    }

    /**
     * Get socialnetworks
     *
     * @return boolean 
     */
    public function getSocialnetworks()
    {
        return $this->socialnetworks;
    }

    /**
     * Set showplaylist
     *
     * @param boolean $showplaylist
     */
    public function setShowplaylist($showplaylist)
    {
        $this->showplaylist = $showplaylist;
    }

    /**
     * Get showplaylist
     *
     * @return boolean 
     */
    public function getShowplaylist()
    {
        return $this->showplaylist;
    }

    /**
     * Set language_en
     *
     * @param boolean $languageEn
     */
    public function setLanguageEn($languageEn)
    {
        $this->language_en = $languageEn;
    }

    /**
     * Get language_en
     *
     * @return boolean 
     */
    public function getLanguageEn()
    {
        return $this->language_en;
    }

    /**
     * Set language_fr
     *
     * @param boolean $languageFr
     */
    public function setLanguageFr($languageFr)
    {
        $this->language_fr = $languageFr;
    }

    /**
     * Get language_fr
     *
     * @return boolean 
     */
    public function getLanguageFr()
    {
        return $this->language_fr;
    }

    /**
     * Set language_de
     *
     * @param boolean $languageDe
     */
    public function setLanguageDe($languageDe)
    {
        $this->language_de = $languageDe;
    }

    /**
     * Get language_de
     *
     * @return boolean 
     */
    public function getLanguageDe()
    {
        return $this->language_de;
    }

    /**
     * Set header
     *
     * @param text $header
     */
    public function setHeader($header)
    {
        $this->header = $header;
    }

    /**
     * Get header
     *
     * @return text 
     */
    public function getHeader()
    {
        return $this->header;
    }
    
    public function __construct()
    {
        $this->videos = new \Doctrine\Common\Collections\ArrayCollection();
    	$this->pages = new \Doctrine\Common\Collections\ArrayCollection();
    	
    	$this->socialnetworks = false;
    	$this->showplaylist = false;
    	$this->language_de = true;
    	$this->language_en = false;
    	$this->language_fr = false;
    	$this->header = '';
    	$this->menu = '';
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
     * Add pages
     *
     * @param Flou\VideoManagerBundle\Entity\Page $pages
     */
    public function addPage(\Flou\VideoManagerBundle\Entity\Page $pages)
    {
        $this->pages[] = $pages;
        $pages->setChannel($this);
    }

    /**
     * Get pages
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getPages()
    {
        return $this->pages;
    }

    /**
     * Set defaultpage
     *
     * @param Flou\VideoManagerBundle\Entity\Page $defaultpage
     */
    public function setDefaultpage($defaultpage)
    {
    	if($defaultpage != null)
    	{
        	$this->defaultpage = $defaultpage;
    	}
    	else 
    	{
    		$this->defaultpage = null;
    	}
    }

    /**
     * Get defaultpage
     *
     * @return Flou\VideoManagerBundle\Entity\Page 
     */
    public function getDefaultpage()
    {
        return $this->defaultpage;
    }

    /**
     * Set design
     *
     * @param Flou\VideoManagerBundle\Entity\Design $design
     */
    public function setDesign(\Flou\VideoManagerBundle\Entity\Design $design)
    {
        $this->design = $design;
    }

    /**
     * Get design
     *
     * @return Flou\VideoManagerBundle\Entity\Design 
     */
    public function getDesign()
    {
        return $this->design;
    }

    /**
     * Add videos
     *
     * @param Flou\VideoManagerBundle\Entity\Video $videos
     */
    public function addVideo(\Flou\VideoManagerBundle\Entity\Video $videos)
    {
        $this->videos[] = $videos;
        $videos->setChannel($this);
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
     * Set usertemplate
     *
     * @param text $usertemplate
     */
    public function setUsertemplate($usertemplate)
    {
        $this->usertemplate = $usertemplate;
    }

    /**
     * Get usertemplate
     *
     * @return text 
     */
    public function getUsertemplate()
    {
        return $this->usertemplate;
    }

    /**
     * Set streamdistribution
     *
     * @param string $streamdistribution
     */
    public function setStreamdistribution($streamdistribution)
    {
        $this->streamdistribution = $streamdistribution;
    }

    /**
     * Get streamdistribution
     *
     * @return string 
     */
    public function getStreamdistribution()
    {
        return $this->streamdistribution;
    }

    /**
     * Set downloaddistribution
     *
     * @param string $downloaddistribution
     */
    public function setDownloaddistribution($downloaddistribution)
    {
        $this->downloaddistribution = $downloaddistribution;
    }

    /**
     * Get downloaddistribution
     *
     * @return string 
     */
    public function getDownloaddistribution()
    {
        return $this->downloaddistribution;
    }

    /**
     * Set channelname
     *
     * @param string $channelname
     */
    public function setChannelname($channelname)
    {
        $this->channelname = $channelname;
    }

    /**
     * Get channelname
     *
     * @return string 
     */
    public function getChannelname()
    {
        return $this->channelname;
    }

    /**
     * Add playlists
     *
     * @param Flou\VideoManagerBundle\Entity\Playlist $playlists
     */
    public function addPlaylist(\Flou\VideoManagerBundle\Entity\Playlist $playlists)
    {
        $this->playlists[] = $playlists;
        $playlists->setChannel($this);
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
     * Add user
     *
     * @param Flou\VideoManagerBundle\Entity\User $user
     */
    public function addUser(\Flou\VideoManagerBundle\Entity\User $user)
    {
        $this->user[] = $user;
    }

    /**
     * Get user
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set playlist_enabled
     *
     * @param boolean $playlistEnabled
     */
    public function setPlaylistEnabled($playlistEnabled)
    {
        $this->playlist_enabled = $playlistEnabled;
    }

    /**
     * Get playlist_enabled
     *
     * @return boolean 
     */
    public function getPlaylistEnabled()
    {
        return $this->playlist_enabled;
    }

    /**
     * Set max_videos
     *
     * @param integer $maxVideos
     */
    public function setMaxVideos($maxVideos)
    {
        $this->max_videos = $maxVideos;
    }

    /**
     * Get max_videos
     *
     * @return integer 
     */
    public function getMaxVideos()
    {
        return $this->max_videos;
    }

    /**
     * Set use_html5
     *
     * @param boolean $useHtml5
     */
    public function setUseHtml5($useHtml5)
    {
        $this->use_html5 = $useHtml5;
    }

    /**
     * Get use_html5
     *
     * @return boolean 
     */
    public function getUseHtml5()
    {
        return $this->use_html5;
    }

    /**
     * Set use_hyphernate
     *
     * @param boolean $useHyphernate
     */
    public function setUseHyphernate($useHyphernate)
    {
        $this->use_hyphernate = $useHyphernate;
    }

    /**
     * Get use_hyphernate
     *
     * @return boolean 
     */
    public function getUseHyphernate()
    {
        return $this->use_hyphernate;
    }

    /**
     * Set fbid
     *
     * @param string $fbid
     */
    public function setFbid($fbid)
    {
        $this->fbid = $fbid;
    }

    /**
     * Get fbid
     *
     * @return string 
     */
    public function getFbid()
    {
        return $this->fbid;
    }

    /**
     * Set contactemail
     *
     * @param string $contactemail
     * @return Channel
     */
    public function setContactemail($contactemail)
    {
        $this->contactemail = $contactemail;
    
        return $this;
    }

    /**
     * Get contactemail
     *
     * @return string 
     */
    public function getContactemail()
    {
        return $this->contactemail;
    }

    /**
     * Remove user
     *
     * @param Flou\VideoManagerBundle\Entity\User $user
     */
    public function removeUser(\Flou\VideoManagerBundle\Entity\User $user)
    {
        $this->user->removeElement($user);
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

    /**
     * Remove pages
     *
     * @param Flou\VideoManagerBundle\Entity\Page $pages
     */
    public function removePage(\Flou\VideoManagerBundle\Entity\Page $pages)
    {
        $this->pages->removeElement($pages);
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

    /**
     * Set piwikid
     *
     * @param integer $piwikid
     * @return Channel
     */
    public function setPiwikid($piwikid)
    {
        $this->piwikid = $piwikid;
    
        return $this;
    }

    /**
     * Get piwikid
     *
     * @return integer 
     */
    public function getPiwikid()
    {
        return $this->piwikid;
    }

    /**
     * Add galleries
     *
     * @param Flou\VideoManagerBundle\Entity\Gallery $galleries
     * @return Channel
     */
    public function addGallerie(\Flou\VideoManagerBundle\Entity\Gallery $galleries)
    {
        $this->galleries[] = $galleries;
    
        return $this;
    }

    /**
     * Remove galleries
     *
     * @param Flou\VideoManagerBundle\Entity\Gallery $galleries
     */
    public function removeGallerie(\Flou\VideoManagerBundle\Entity\Gallery $galleries)
    {
        $this->galleries->removeElement($galleries);
    }

    /**
     * Get galleries
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getGalleries()
    {
        return $this->galleries;
    }
}