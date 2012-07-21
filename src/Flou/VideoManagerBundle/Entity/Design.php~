<?php

namespace Flou\VideoManagerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Flou\VideoManagerBundle\Repository\DesignRepository")
 * @ORM\Table(name="flou_design")
 */
class Design
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToOne(targetEntity="Channel", mappedBy="design")
     */
    private $channel;
    
    /**
     * @ORM\Column(type="string", length=6, nullable=true)
     */
    private $color1;
    
    /**
     * @ORM\Column(type="string", length=6, nullable=true)
     */
    private $color2;
    
    /**
     * @ORM\Column(type="string", length=6, nullable=true)
     */
    private $color3;
    
    /**
     * @ORM\Column(type="string", length=6, nullable=true)
     */
    private $hovercolor1;
    
    /**
     * @ORM\Column(type="string", length=6, nullable=true)
     */
    private $hovercolor2;
    
    /**
     * @ORM\Column(type="string", length=6, nullable=true)
     */
    private $hovercolor3;
    
    /**
     * @ORM\Column(type="string", length=6, nullable=true)
     */
    private $fontcolor1;
    
    /**
     * @ORM\Column(type="string", length=6, nullable=true)
     */
    private $fontcolor2;
    
    /**
     * @ORM\Column(type="string", length=6, nullable=true)
     */
    private $fontcolor3;
    
    /**
     * @ORM\Column(type="string", length=6, nullable=true)
     */
    private $hoverfontcolor1;
    
    /**
     * @ORM\Column(type="string", length=6, nullable=true)
     */
    private $hoverfontcolor2;
    
    /**
     * @ORM\Column(type="string", length=6, nullable=true)
     */
    private $hoverfontcolor3;
    
    /**
     * @ORM\Column(type="string", length=6, nullable=true)
     */
    private $linkcolor1;
    
    /**
     * @ORM\Column(type="string", length=6, nullable=true)
     */
    private $linkcolor2;
    
    /**
     * @ORM\Column(type="string", length=6, nullable=true)
     */
    private $linkcolor3;
    
    /**
     * @ORM\Column(type="string", length=6, nullable=true)
     */
    private $hoverlinkcolor1;
    
    /**
     * @ORM\Column(type="string", length=6, nullable=true)
     */
    private $hoverlinkcolor2;
    
    /**
     * @ORM\Column(type="string", length=6, nullable=true)
     */
    private $hoverlinkcolor3;
    
    /**
     * @ORM\Column(type="string", length=6, nullable=true)
     */
    private $headingcolor;
    
    /**
     * @ORM\ManyToOne(targetEntity="Font")
     */
    private $font;
    
    /**
     * @ORM\ManyToOne(targetEntity="Font")
     */
    private $headingfont;
    
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $head;
    
    /**
     * @ORM\ManyToOne(targetEntity="Template")
     */
    private $template;
    
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $usertemplate;

    public function __construct()
    {    	 
    	$this->color1 = '';
    	$this->color2 = '';
    	$this->color3 = '';
    	$this->hovercolor1 = '';
    	$this->hovercolor2 = '';
    	$this->hovercolor3 = '';
    	$this->fontcolor1 = '';
    	$this->fontcolor2 = '';
    	$this->fontcolor3 = '';
    	$this->hoverfontcolor1 = '';
    	$this->hoverfontcolor2 = '';
    	$this->hoverfontcolor3 = '';
    	$this->linkcolor1= '';
    	$this->linkcolor2= '';
    	$this->linkcolor3= '';
    	$this->head= '';
    	$this->usertemplate = ''; 	
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
     * Set color1
     *
     * @param string $color1
     */
    public function setColor1($color1)
    {
        $this->color1 = $color1;
    }

    /**
     * Get color1
     *
     * @return string 
     */
    public function getColor1()
    {
        return $this->color1;
    }

    /**
     * Set color2
     *
     * @param string $color2
     */
    public function setColor2($color2)
    {
        $this->color2 = $color2;
    }

    /**
     * Get color2
     *
     * @return string 
     */
    public function getColor2()
    {
        return $this->color2;
    }

    /**
     * Set color3
     *
     * @param string $color3
     */
    public function setColor3($color3)
    {
        $this->color3 = $color3;
    }

    /**
     * Get color3
     *
     * @return string 
     */
    public function getColor3()
    {
        return $this->color3;
    }

    /**
     * Set hovercolor1
     *
     * @param string $hovercolor1
     */
    public function setHovercolor1($hovercolor1)
    {
        $this->hovercolor1 = $hovercolor1;
    }

    /**
     * Get hovercolor1
     *
     * @return string 
     */
    public function getHovercolor1()
    {
        return $this->hovercolor1;
    }

    /**
     * Set hovercolor2
     *
     * @param string $hovercolor2
     */
    public function setHovercolor2($hovercolor2)
    {
        $this->hovercolor2 = $hovercolor2;
    }

    /**
     * Get hovercolor2
     *
     * @return string 
     */
    public function getHovercolor2()
    {
        return $this->hovercolor2;
    }

    /**
     * Set hovercolor3
     *
     * @param string $hovercolor3
     */
    public function setHovercolor3($hovercolor3)
    {
        $this->hovercolor3 = $hovercolor3;
    }

    /**
     * Get hovercolor3
     *
     * @return string 
     */
    public function getHovercolor3()
    {
        return $this->hovercolor3;
    }

    /**
     * Set fontcolor1
     *
     * @param string $fontcolor1
     */
    public function setFontcolor1($fontcolor1)
    {
        $this->fontcolor1 = $fontcolor1;
    }

    /**
     * Get fontcolor1
     *
     * @return string 
     */
    public function getFontcolor1()
    {
        return $this->fontcolor1;
    }

    /**
     * Set fontcolor2
     *
     * @param string $fontcolor2
     */
    public function setFontcolor2($fontcolor2)
    {
        $this->fontcolor2 = $fontcolor2;
    }

    /**
     * Get fontcolor2
     *
     * @return string 
     */
    public function getFontcolor2()
    {
        return $this->fontcolor2;
    }

    /**
     * Set fontcolor3
     *
     * @param string $fontcolor3
     */
    public function setFontcolor3($fontcolor3)
    {
        $this->fontcolor3 = $fontcolor3;
    }

    /**
     * Get fontcolor3
     *
     * @return string 
     */
    public function getFontcolor3()
    {
        return $this->fontcolor3;
    }

    /**
     * Set hoverfontcolor1
     *
     * @param string $hoverfontcolor1
     */
    public function setHoverfontcolor1($hoverfontcolor1)
    {
        $this->hoverfontcolor1 = $hoverfontcolor1;
    }

    /**
     * Get hoverfontcolor1
     *
     * @return string 
     */
    public function getHoverfontcolor1()
    {
        return $this->hoverfontcolor1;
    }

    /**
     * Set hoverfontcolor2
     *
     * @param string $hoverfontcolor2
     */
    public function setHoverfontcolor2($hoverfontcolor2)
    {
        $this->hoverfontcolor2 = $hoverfontcolor2;
    }

    /**
     * Get hoverfontcolor2
     *
     * @return string 
     */
    public function getHoverfontcolor2()
    {
        return $this->hoverfontcolor2;
    }

    /**
     * Set hoverfontcolor3
     *
     * @param string $hoverfontcolor3
     */
    public function setHoverfontcolor3($hoverfontcolor3)
    {
        $this->hoverfontcolor3 = $hoverfontcolor3;
    }

    /**
     * Get hoverfontcolor3
     *
     * @return string 
     */
    public function getHoverfontcolor3()
    {
        return $this->hoverfontcolor3;
    }

    /**
     * Set linkcolor1
     *
     * @param string $linkcolor1
     */
    public function setLinkcolor1($linkcolor1)
    {
        $this->linkcolor1 = $linkcolor1;
    }

    /**
     * Get linkcolor1
     *
     * @return string 
     */
    public function getLinkcolor1()
    {
        return $this->linkcolor1;
    }

    /**
     * Set linkcolor2
     *
     * @param string $linkcolor2
     */
    public function setLinkcolor2($linkcolor2)
    {
        $this->linkcolor2 = $linkcolor2;
    }

    /**
     * Get linkcolor2
     *
     * @return string 
     */
    public function getLinkcolor2()
    {
        return $this->linkcolor2;
    }

    /**
     * Set linkcolor3
     *
     * @param string $linkcolor3
     */
    public function setLinkcolor3($linkcolor3)
    {
        $this->linkcolor3 = $linkcolor3;
    }

    /**
     * Get linkcolor3
     *
     * @return string 
     */
    public function getLinkcolor3()
    {
        return $this->linkcolor3;
    }

    /**
     * Set font
     *
     * @param Flou\VideoManagerBundle\Entity\Font $font
     */
    public function setFont(\Flou\VideoManagerBundle\Entity\Font $font)
    {
        $this->font = $font;
    }

    /**
     * Get font
     *
     * @return Flou\VideoManagerBundle\Entity\Font 
     */
    public function getFont()
    {
        return $this->font;
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
     * Set template
     *
     * @param Flou\VideoManagerBundle\Entity\Template $template
     */
    public function setTemplate(\Flou\VideoManagerBundle\Entity\Template $template)
    {
        $this->template = $template;
    }

    /**
     * Get template
     *
     * @return Flou\VideoManagerBundle\Entity\Template 
     */
    public function getTemplate()
    {
        return $this->template;
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
     * Set headingcolor
     *
     * @param string $headingcolor
     */
    public function setHeadingcolor($headingcolor)
    {
        $this->headingcolor = $headingcolor;
    }

    /**
     * Get headingcolor
     *
     * @return string 
     */
    public function getHeadingcolor()
    {
        return $this->headingcolor;
    }

    /**
     * Set headingfont
     *
     * @param Flou\VideoManagerBundle\Entity\Font $headingfont
     */
    public function setHeadingfont(\Flou\VideoManagerBundle\Entity\Font $headingfont)
    {
        $this->headingfont = $headingfont;
    }

    /**
     * Get headingfont
     *
     * @return Flou\VideoManagerBundle\Entity\Font 
     */
    public function getHeadingfont()
    {
        return $this->headingfont;
    }

    /**
     * Set hoverlinkcolor1
     *
     * @param string $hoverlinkcolor1
     */
    public function setHoverlinkcolor1($hoverlinkcolor1)
    {
        $this->hoverlinkcolor1 = $hoverlinkcolor1;
    }

    /**
     * Get hoverlinkcolor1
     *
     * @return string 
     */
    public function getHoverlinkcolor1()
    {
        return $this->hoverlinkcolor1;
    }

    /**
     * Set hoverlinkcolor2
     *
     * @param string $hoverlinkcolor2
     */
    public function setHoverlinkcolor2($hoverlinkcolor2)
    {
        $this->hoverlinkcolor2 = $hoverlinkcolor2;
    }

    /**
     * Get hoverlinkcolor2
     *
     * @return string 
     */
    public function getHoverlinkcolor2()
    {
        return $this->hoverlinkcolor2;
    }

    /**
     * Set hoverlinkcolor3
     *
     * @param string $hoverlinkcolor3
     */
    public function setHoverlinkcolor3($hoverlinkcolor3)
    {
        $this->hoverlinkcolor3 = $hoverlinkcolor3;
    }

    /**
     * Get hoverlinkcolor3
     *
     * @return string 
     */
    public function getHoverlinkcolor3()
    {
        return $this->hoverlinkcolor3;
    }

    /**
     * Set head
     *
     * @param text $head
     */
    public function setHead($head)
    {
        $this->head = $head;
    }

    /**
     * Get head
     *
     * @return text 
     */
    public function getHead()
    {
        return $this->head;
    }
}