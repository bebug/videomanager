<?php

namespace Flou\VideoManagerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="flou_font")
 */
class Font
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name;
    
    /**
     * @ORM\Column(type="string", length=300)
     */
    private $importtag;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
    
    function __toString()
    {
    	return $this->getName();
    }

    /**
     * Set name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set importtag
     *
     * @param string $importtag
     */
    public function setImporttag($importtag)
    {
        $this->importtag = $importtag;
    }

    /**
     * Get importtag
     *
     * @return string 
     */
    public function getImporttag()
    {
        return $this->importtag;
    }
}