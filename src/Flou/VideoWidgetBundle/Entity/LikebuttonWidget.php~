<?php
namespace Flou\VideoWidgetBundle\Entity;
use Flou\VideoManagerBundle\Entity\AbstractWidget;
use Flou\VideoManagerBundle\Entity\Title;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Flou\VideoWidgetBundle\Repository\LikebuttonWidgetRepository")
 * @ORM\Table(name="flou_likebuttonwidget")
 */
class LikebuttonWidget extends AbstractWidget{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;
	
	/**
	 * @ORM\Column(type="boolean")
	 */
	protected $facebook_enabled;
	
	/**
	 * @ORM\Column(type="boolean")
	 */
	protected $twitter_enabled;
	
	/**
	 * @ORM\Column(type="boolean")
	 */
	protected $google_enabled;
	
	/**
	 * @ORM\Column(type="boolean")
	 */
	protected $bigsize;
	
	function name($lang){
		if($lang == 'de'){
			return $this->getTitle()->getTitleDe();
		}elseif($lang == 'en'){
			return $this->getTitle()->getTitleEn();
		}else{
			return $this->getTitle()->getTitleFr();
		}
	}
	
	function drawWidget($container, $channelid, $lang){
		return	$container->get('templating')->render('FlouVideoWidgetBundle:LikebuttonWidget:like.html.twig', array('widget' => $this, 'url' => $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'])
		);
	}
	
	function type(){
		return "Likebuttonwidget";
	}
	
	function routePrefix(){
		return "likebuttonwidget";
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
     * Set facebook_enabled
     *
     * @param boolean $facebookEnabled
     */
    public function setFacebookEnabled($facebookEnabled)
    {
        $this->facebook_enabled = $facebookEnabled;
    }

    /**
     * Get facebook_enabled
     *
     * @return boolean 
     */
    public function getFacebookEnabled()
    {
        return $this->facebook_enabled;
    }

    /**
     * Set twitter_enabled
     *
     * @param boolean $twitterEnabled
     */
    public function setTwitterEnabled($twitterEnabled)
    {
        $this->twitter_enabled = $twitterEnabled;
    }

    /**
     * Get twitter_enabled
     *
     * @return boolean 
     */
    public function getTwitterEnabled()
    {
        return $this->twitter_enabled;
    }

    /**
     * Set google_enabled
     *
     * @param boolean $googleEnabled
     */
    public function setGoogleEnabled($googleEnabled)
    {
        $this->google_enabled = $googleEnabled;
    }

    /**
     * Get google_enabled
     *
     * @return boolean 
     */
    public function getGoogleEnabled()
    {
        return $this->google_enabled;
    }

    /**
     * Set bigsize
     *
     * @param boolean $bigsize
     */
    public function setBigsize($bigsize)
    {
        $this->bigsize = $bigsize;
    }

    /**
     * Get bigsize
     *
     * @return boolean 
     */
    public function getBigsize()
    {
        return $this->bigsize;
    }
}