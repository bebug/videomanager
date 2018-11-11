<?php
namespace Flou\VideoWidgetBundle\Entity;
use Flou\VideoManagerBundle\Entity\AbstractWidget;
use Flou\VideoManagerBundle\Entity\Description;
use Flou\VideoManagerBundle\Entity\Title;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Flou\VideoWidgetBundle\Repository\TextWidgetRepository")
 * @ORM\Table(name="flou_textwidget")
 */
class TextWidget extends AbstractWidget
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\OneToOne(targetEntity="Flou\VideoManagerBundle\Entity\Description")
     */
    private $description;
      
    
    function drawWidget($container, $channelid, $lang){
    	if($lang == 'de'){
    		return $this->description->getDescriptionDe();
    	}elseif($lang == 'en'){
    		return $this->description->getDescriptionEn();
    	}else{
    		return $this->description->getDescriptionFr();
    	}
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
    	return "Textwidget";
    }
    
    function routePrefix(){
    	return "textwidget";
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
     * @return Flou\VideoWidgetBundle\Entity\Description 
     */
    public function getDescription()
    {
        return $this->description;
    }
}