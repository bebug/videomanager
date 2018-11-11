<?php
namespace Flou\VideoWidgetBundle\Entity;
use Flou\VideoManagerBundle\Entity\AbstractWidget;
use Flou\VideoManagerBundle\Entity\Description;
use Flou\VideoManagerBundle\Entity\Title;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Flou\VideoWidgetBundle\Repository\FbCommentWidgetRepository")
 * @ORM\Table(name="flou_fbcommentwidget")
 */
class FbCommentWidget extends AbstractWidget
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;
	
	/**
	* @ORM\Column(type="boolean")
	*/
	protected $dark;
	
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
		return	$container->get('templating')->render('FlouVideoWidgetBundle:FbCommentWidget:comment.html.twig', array('dark'=> $this->getDark(), 'url' => $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'])
		);
	}
	
	function type(){
		return "fbcommentwidget";
	}
	
	function routePrefix(){
		return "fbcommentwidget";
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
     * Set dark
     *
     * @param boolean $dark
     */
    public function setDark($dark)
    {
        $this->dark = $dark;
    }

    /**
     * Get dark
     *
     * @return boolean 
     */
    public function getDark()
    {
        return $this->dark;
    }
}