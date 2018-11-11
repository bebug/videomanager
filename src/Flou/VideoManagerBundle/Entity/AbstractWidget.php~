<?php

namespace Flou\VideoManagerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @author Florian
 * @ORM\MappedSuperclass
 */
abstract class AbstractWidget{
	
	/**
	 * @ORM\ManyToOne(targetEntity="Pageposition")
	 */
	private $position;
	
	/**
	 * @ORM\Column(type="integer")
	 */
	private $orderrank;
	
	/**
	 * @ORM\Column(type="boolean")
	 */
	private $showonpage;
	
	/**
	 * @ORM\Column(type="boolean")
	 */
	private $showonvideo;
	
    /**
     * @ORM\ManyToOne(targetEntity="Channel")
     */
	private $channel;
	
	/**
	 * @ORM\ManyToOne(targetEntity="Page")
	 * @ORM\JoinColumn(nullable=true)
	 */
	private $page;
	
	/**
	 * @ORM\OneToOne(targetEntity="Flou\VideoManagerBundle\Entity\Title")
	 */
	private $title;
	
	abstract protected function drawWidget($container, $channelid, $lang);
	abstract protected function routePrefix();
	abstract protected function name($lang);
	abstract protected function type();

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
     * Set position
     *
     * @param Flou\VideoManagerBundle\Entity\Pageposition $position
     */
    public function setPosition(\Flou\VideoManagerBundle\Entity\Pageposition $position)
    {
        $this->position = $position;
    }

    /**
     * Get position
     *
     * @return Flou\VideoManagerBundle\Entity\Pageposition 
     */
    public function getPosition()
    {
        return $this->position;
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
     * Set showonpage
     *
     * @param boolean $showonpage
     */
    public function setShowonpage($showonpage)
    {
        $this->showonpage = $showonpage;
    }

    /**
     * Get showonpage
     *
     * @return boolean 
     */
    public function getShowonpage()
    {
        return $this->showonpage;
    }

    /**
     * Set showonvideo
     *
     * @param boolean $showonvideo
     */
    public function setShowonvideo($showonvideo)
    {
        $this->showonvideo = $showonvideo;
    }

    /**
     * Get showonvideo
     *
     * @return boolean 
     */
    public function getShowonvideo()
    {
        return $this->showonvideo;
    }

    /**
     * Set page
     *
     * @param Flou\VideoManagerBundle\Entity\Page $page
     */
    public function setPage($page)
    {
        $this->page = $page;
    }

    /**
     * Get page
     *
     * @return Flou\VideoManagerBundle\Entity\Page 
     */
    public function getPage()
    {
        return $this->page;
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
}