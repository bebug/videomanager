<?php

namespace Flou\VideoManagerBundle\Entity;

use Doctrine\ORM\Mapping\OneToOne;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Flou\VideoManagerBundle\Repository\PageRepository")
 * @ORM\Table(name="flou_page")
 */
class Page
{
	const VIDEO = -1;
	const GALLERY = -10;
	const PHOTO = -20;
	const OTHER = -100;
	const ALL = -101;
	
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="Channel", inversedBy="pages")
     * @ORM\JoinColumn(name="channel_id", referencedColumnName="id")
     */
    private $channel;
    
    /**
     * @ORM\OneToOne(targetEntity="Description")
     */
    private $description;
    
    /**
     * @ORM\OneToOne(targetEntity="Title")
     */
    private $title;
    
    /**
     * @ORM\ManyToOne(targetEntity="Pageposition")
     */
    private $pageposition;
    
    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $hyperlink;
    
    /**
     * @ORM\OneToOne(targetEntity="Title")
     */
    private $group;
    
    /**
     * @ORM\Column(type="integer")
     */
    private $orderrank;

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
     * Set orderrank
     *
     * @param integer $orderrank
     */
    public function setOrderrank($orderrank)
    {
        $this->orderrank = $orderrank;
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
     * Set pageposition
     *
     * @param Flou\VideoManagerBundle\Entity\Pageposition $pageposition
     */
    public function setPageposition(\Flou\VideoManagerBundle\Entity\Pageposition $pageposition)
    {
        $this->pageposition = $pageposition;
    }

    /**
     * Get pageposition
     *
     * @return Flou\VideoManagerBundle\Entity\Pageposition 
     */
    public function getPageposition()
    {
        return $this->pageposition;
    }

    /**
     * Set hyperlink
     *
     * @param string $hyperlink
     */
    public function setHyperlink($hyperlink)
    {
        $this->hyperlink = $hyperlink;
    }

    /**
     * Get hyperlink
     *
     * @return string 
     */
    public function getHyperlink()
    {
        return $this->hyperlink;
    }

    /**
     * Set tag
     *
     * @param string $tag
     */
    public function setTag($tag)
    {
        $this->tag = $tag;
    }

    /**
     * Get tag
     *
     * @return string 
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * Set group
     *
     * @param Flou\VideoManagerBundle\Entity\Title $group
     */
    public function setGroup(\Flou\VideoManagerBundle\Entity\Title $group)
    {
        $this->group = $group;
    }

    /**
     * Get group
     *
     * @return Flou\VideoManagerBundle\Entity\Title 
     */
    public function getGroup()
    {
        return $this->group;
    }
}