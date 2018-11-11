<?php
namespace Flou\VideoWidgetBundle\Entity;
use Flou\VideoManagerBundle\Entity\AbstractWidget;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Flou\VideoWidgetBundle\Repository\FollowWidgetRepository")
 * @ORM\Table(name="flou_followwidget")
 */
class FollowWidget extends AbstractWidget
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;
	
	/**
	 * @ORM\Column(type="string", length=100, nullable=true)
	 */
	private $fblink;
	
	/**
	 * @ORM\Column(type="string", length=100, nullable=true)
	 */
	private $inlink;
	
	/**
	 * @ORM\Column(type="string", length=100, nullable=true)
	 */
	private $googlelink;
	
	/**
	 * @ORM\Column(type="string", length=100, nullable=true)
	 */
	private $xinglink;
	
	/**
	 * @ORM\Column(type="string", length=100, nullable=true)
	 */
	private $ytlink;
	
	/**
	 * @ORM\Column(type="string", length=100, nullable=true)
	 */
	private $twitterlink;
	
	function drawWidget($container, $channelid, $lang){
	
		return	$container->get('templating')->render('FlouVideoWidgetBundle:FollowWidget:follow.html.twig', array('widget' => $this)
			);
	}
	
	function name($lang){
		if($lang == 'de'){
			return $this->getTitle()->getTitleDe();
		}elseif($lang == 'en'){
			return $this->getTitle()->getTitleEn();
		}else{
			return $this->getTitle()->getTitleFr();
		}
	}
	
	function type(){
		return "Followwidget";
	}
	
	function routePrefix(){
		return "followwidget";
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
     * Set fblink
     *
     * @param string $fblink
     */
    public function setFblink($fblink)
    {
        $this->fblink = $fblink;
    }

    /**
     * Get fblink
     *
     * @return string 
     */
    public function getFblink()
    {
        return $this->fblink;
    }

    /**
     * Set inlink
     *
     * @param string $inlink
     */
    public function setInlink($inlink)
    {
        $this->inlink = $inlink;
    }

    /**
     * Get inlink
     *
     * @return string 
     */
    public function getInlink()
    {
        return $this->inlink;
    }

    /**
     * Set googlelink
     *
     * @param string $googlelink
     */
    public function setGooglelink($googlelink)
    {
        $this->googlelink = $googlelink;
    }

    /**
     * Get googlelink
     *
     * @return string 
     */
    public function getGooglelink()
    {
        return $this->googlelink;
    }

    /**
     * Set xinglink
     *
     * @param string $xinglink
     */
    public function setXinglink($xinglink)
    {
        $this->xinglink = $xinglink;
    }

    /**
     * Get xinglink
     *
     * @return string 
     */
    public function getXinglink()
    {
        return $this->xinglink;
    }

    /**
     * Set ytlink
     *
     * @param string $ytlink
     */
    public function setYtlink($ytlink)
    {
        $this->ytlink = $ytlink;
    }

    /**
     * Get ytlink
     *
     * @return string 
     */
    public function getYtlink()
    {
        return $this->ytlink;
    }

    /**
     * Set twitterlink
     *
     * @param string $twitterlink
     */
    public function setTwitterlink($twitterlink)
    {
        $this->twitterlink = $twitterlink;
    }

    /**
     * Get twitterlink
     *
     * @return string 
     */
    public function getTwitterlink()
    {
        return $this->twitterlink;
    }
}