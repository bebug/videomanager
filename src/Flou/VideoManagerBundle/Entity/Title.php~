<?php

namespace Flou\VideoManagerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="flou_title")
 */
class Title
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $title_en;
    
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $title_fr;
    
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $title_de;

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
     * Set title_en
     *
     * @param text $titleEn
     */
    public function setTitleEn($titleEn)
    {
        $this->title_en = $titleEn;
    }

    /**
     * Get title_en
     *
     * @return text 
     */
    public function getTitleEn()
    {
        return $this->title_en;
    }

    /**
     * Set title_fr
     *
     * @param text $titleFr
     */
    public function setTitleFr($titleFr)
    {
        $this->title_fr = $titleFr;
    }

    /**
     * Get title_fr
     *
     * @return text 
     */
    public function getTitleFr()
    {
        return $this->title_fr;
    }

    /**
     * Set title_de
     *
     * @param text $titleDe
     */
    public function setTitleDe($titleDe)
    {
        $this->title_de = $titleDe;
    }

    /**
     * Get title_de
     *
     * @return text 
     */
    public function getTitleDe()
    {
        return $this->title_de;
    }
}