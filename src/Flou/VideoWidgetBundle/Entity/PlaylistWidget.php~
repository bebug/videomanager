<?php
namespace Flou\VideoWidgetBundle\Entity;
use Flou\VideoManagerBundle\Entity\AbstractWidget;
use Flou\VideoManagerBundle\Entity\Description;
use Flou\VideoManagerBundle\Entity\Title;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Flou\VideoWidgetBundle\Repository\PlaylistWidgetRepository")
 * @ORM\Table(name="flou_playlistwidget")
 */
class PlaylistWidget extends AbstractWidget
{
	const VERTICAL = 0;
	const HORIZONTAL = 1;
	
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\Column(type="integer")
     */
    private $rendertype;
    
    /**
     * @ORM\Column(type="boolean")
     */
    protected $bigsize;

    
    function drawWidget($container, $channelid, $lang){

    	$em = $container->get('doctrine.orm.entity_manager');

    	$playlists = $em->getRepository('FlouVideoManagerBundle:Playlist')->findUnitedListByChannelId($channelid, $lang);
    	
    	return	$container->get('templating')->render('FlouVideoWidgetBundle:PlaylistWidget:playlist.html.twig', array('widget' => $this, 'channelid' => $channelid, 'playlists' => $playlists)
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
    	return "Playlistwidget";
    }
    
    function routePrefix(){
    	return "playlistwidget";
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
     * Set rendertype
     *
     * @param integer $rendertype
     */
    public function setRendertype($rendertype)
    {
        $this->rendertype = $rendertype;
    }

    /**
     * Get rendertype
     *
     * @return integer 
     */
    public function getRendertype()
    {
        return $this->rendertype;
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