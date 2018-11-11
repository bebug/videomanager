<?php 

namespace Flou\VideoManagerBundle\Controller;

use Flou\VideoManagerBundle\Entity\Page;

use Flou\VideoManagerBundle\Entity\Youtubelink;

use Flou\VideoManagerBundle\FlouVideoManagerBundle;
use Flou\VideoManagerBundle\Entity\Video;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;


/**
 * @Template()
 */
class WidgetController extends Controller
{
	public static function getWidgetInfo(){
		return array(array('name' => 'Text-Widget', 'prefix' => 'textwidget', 'namespace' => 'FlouVideoWidgetBundle:TextWidget'),
				array('name' => 'Playlist-Widget', 'prefix' => 'playlistwidget', 'namespace' => 'FlouVideoWidgetBundle:PlaylistWidget'),
				array('name' => 'Facebook-Kommentar-Widget', 'prefix' => 'fbcommentwidget', 'namespace' => 'FlouVideoWidgetBundle:FbCommentWidget'),
				array('name' => 'Follow-Widget', 'prefix' => 'followwidget', 'namespace' => 'FlouVideoWidgetBundle:FollowWidget'),
				array('name' => 'Likebutton-Widget', 'prefix' => 'likebuttonwidget', 'namespace' => 'FlouVideoWidgetBundle:LikebuttonWidget'),
				);
	}
	
	public function listAction(){
		
		$em = $this->getDoctrine()->getEntityManager();
		$channel = $this->get('security.context')->getToken()->getUser()->getChannel();
		$widgetinfos = $this->getWidgetInfo();
		
		$widgets = array();
		
		foreach($widgetinfos as $widgetinfo){
			$get = $em->getRepository($widgetinfo['namespace'])->findListByChannelId($channel->getId(), Page::ALL);
			
			foreach($get as $item){
				$widgets[] = $item[0];
			}
			
			//if(count($get)>0) $widgets = array_merge($widgets,$get);
		}
		//print_r($widgets);
		
		return $this->render('FlouVideoManagerBundle:Widget:list.html.twig', array(
				'widgetinfos' => $widgetinfos, 'widgets' => $widgets,
		));
	}
	
	public function newlistAction(){
		return $this->render('FlouVideoManagerBundle:Widget:newlist.html.twig', array(
				'widgetinfos' => $this->getWidgetInfo(),
		));
	}
}