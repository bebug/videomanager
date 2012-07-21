<?php

namespace Flou\VideoManagerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="flou_description")
 */
class Description
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
    private $description_en;
    
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description_fr;
    
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description_de;

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
     * Set description_en
     *
     * @param text $descriptionEn
     */
    public function setDescriptionEn($descriptionEn)
    {
        $this->description_en = $descriptionEn;
    }

    /**
     * Get description_en
     *
     * @return text 
     */
    public function getDescriptionEn()
    {
        return $this->description_en;
    }

    /**
     * Set description_fr
     *
     * @param text $descriptionFr
     */
    public function setDescriptionFr($descriptionFr)
    {
        $this->description_fr = $descriptionFr;
    }

    /**
     * Get description_fr
     *
     * @return text 
     */
    public function getDescriptionFr()
    {
        return $this->description_fr;
    }

    /**
     * Set description_de
     *
     * @param text $descriptionDe
     */
    public function setDescriptionDe($descriptionDe)
    {
        $this->description_de = $descriptionDe;
    }

    /**
     * Get description_de
     *
     * @return text 
     */
    public function getDescriptionDe()
    {
        return $this->description_de;
    }
}