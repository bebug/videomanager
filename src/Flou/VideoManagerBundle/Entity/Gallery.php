<?php

namespace Flou\VideoManagerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Flou\VideoManagerBundle\Repository\GalleryRepository")
 * @ORM\Table(name="flou_gallery")
 */
class Gallery
{
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
     * @ORM\ManyToOne(targetEntity="Channel", inversedBy="galleries")
     * @ORM\JoinColumn(name="channel_id", referencedColumnName="id")
     */
    private $channel;
    
    /**
     * @ORM\OneToMany(targetEntity="Photo", mappedBy="gallery")
     *
     */
    private $photos;
    

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
     * @return Gallery
     */
    public function setTitle(\Flou\VideoManagerBundle\Entity\Title $title = null)
    {
        $this->title = $title;
    
        return $this;
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
     * @return Gallery
     */
    public function setChannel(\Flou\VideoManagerBundle\Entity\Channel $channel = null)
    {
        $this->channel = $channel;
    
        return $this;
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
     * Constructor
     */
    public function __construct()
    {
        $this->photos = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add photos
     *
     * @param Flou\VideoManagerBundle\Entity\Photo $photos
     * @return Gallery
     */
    public function addPhoto(\Flou\VideoManagerBundle\Entity\Photo $photos)
    {
        $this->photos[] = $photos;
    
        return $this;
    }

    /**
     * Remove photos
     *
     * @param Flou\VideoManagerBundle\Entity\Photo $photos
     */
    public function removePhoto(\Flou\VideoManagerBundle\Entity\Photo $photos)
    {
        $this->photos->removeElement($photos);
    }

    /**
     * Get photos
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getPhotos()
    {
        return $this->photos;
    }
}