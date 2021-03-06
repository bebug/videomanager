<?php

namespace Flou\VideoManagerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Flou\VideoManagerBundle\Repository\PhotoRepository")
 * @ORM\Table(name="flou_photo")
 */
class Photo
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
     * @ORM\OneToOne(targetEntity="Description")
     */
    private $description;
    
    /**
     * @ORM\ManyToOne(targetEntity="Gallery", inversedBy="photos")
     * @ORM\JoinColumn(name="gallery_id", referencedColumnName="id")
     */
    private $gallery;
    
    /**
     * @ORM\Column(type="integer")
     */
    private $orderrank;

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
     * @return Photo
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
     * Set description
     *
     * @param Flou\VideoManagerBundle\Entity\Description $description
     * @return Photo
     */
    public function setDescription(\Flou\VideoManagerBundle\Entity\Description $description = null)
    {
        $this->description = $description;
    
        return $this;
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
     * Set gallery
     *
     * @param Flou\VideoManagerBundle\Entity\Gallery $gallery
     * @return Photo
     */
    public function setGallery(\Flou\VideoManagerBundle\Entity\Gallery $gallery = null)
    {
        $this->gallery = $gallery;
    
        return $this;
    }

    /**
     * Get gallery
     *
     * @return Flou\VideoManagerBundle\Entity\Gallery 
     */
    public function getGallery()
    {
        return $this->gallery;
    }

    /**
     * Set orderrank
     *
     * @param integer $orderrank
     * @return Photo
     */
    public function setOrderrank($orderrank)
    {
        $this->orderrank = $orderrank;
    
        return $this;
    }

    /**
     * Get orderrank
     *
     * @return integer 
     */
    public function getOrderrank()
    {
        return $this->orderrank;
    }
}