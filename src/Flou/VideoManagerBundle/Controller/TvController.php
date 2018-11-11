<?php 

namespace Flou\VideoManagerBundle\Controller;

use Flou\VideoManagerBundle\Entity\Contact;

use Flou\VideoManagerBundle\Form\Type\ContactType;

use Flou\VideoManagerBundle\Entity\Page;

use Flou\VideoManagerBundle\DependencyInjection\FlouVideoManagerExtension;
use Flou\VideoManagerBundle\Twig\FlouExtension;

use Flou\VideoManagerBundle\FlouVideoManagerBundle;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


/**
 * @Template()
 */
class TvController extends Controller
{
	
	public function __construct()
	{
	}
	
	public function display($data)
	{
		return $this->render('FlouVideoManagerBundle:Tv:templateloader.html.twig', $data
		);
		//return new Response($this->templateloader->render($data), 200);
	}
	
	public function getLanguage()
	{
		$session = $this->getRequest()->getSession();
		$language = $session->get('language');
		if($language == 'de' || $language == 'en' || $language == 'fr')
		{
			return $language;
		}
		else return 'de';
	}
	
	public function generateData($em, $channel, &$data){
		$data['trigger']= array();
		$data['trigger']['menu1'] = false;
		$data['trigger']['menu2'] = false;
		$data['trigger']['menu3'] = false;
		$data['trigger']['menu4'] = false;
		$data['trigger']['widget1'] = false;
		$data['trigger']['widget2'] = false;
		$data['trigger']['widget3'] = false;
		$data['trigger']['widget4'] = false;
		$data['trigger']['video'] = false;
		$data['trigger']['playlist'] = false;
		$data['trigger']['contact'] = false;
		$data['trigger']['page'] = false;
		$data['trigger']['photo'] = false;
		$data['trigger']['gallery'] = false;
		
		
		$data['info']['language'] = $this->getLanguage();
		$data['info']['channel'] = $channel;
		//$data['info']['assetserver'] = $this->container->getParameter('server.web.url');
		$this->insertChannel($em, $data);
		$this->insertDesign($em, $data);
		$this->insertMenu($em, $data);
		$this->insertWidgets($em, $data, $this->container);
		$this->insertTemplate($data);
		
	}
	
	public function defaultAction($language)
	{
		$em = $this->getDoctrine()->getEntityManager();
		$domain = $em->getRepository('FlouVideoManagerBundle:Domain')->findListByDomain($this->getRequest()->getHost());
		
		$channel = $domain->getChannel();
		$session = $this->getRequest()->getSession();
		$session->set('language', $language);
		
		$data['info']['language'] = $this->getLanguage();
		//$data = $this->generateData($em, $channel->getId(), $data);
			
		$defaultpage = $channel->getDefaultpage();
		if($defaultpage == null){
			return $this->playlistAction(0);
		}
		else if($defaultpage->getHyperlink() != ''){
			return $this->redirect($defaultpage->getHyperlink());
		}
		else {
			return $this->pageAction($defaultpage->getID());
		}
	}
	
	public function pageAction($page)
	{
		$em = $this->getDoctrine()->getEntityManager();
		$domain = $em->getRepository('FlouVideoManagerBundle:Domain')->findListByDomain($this->getRequest()->getHost());
		$channel = $domain->getChannel();
		$data['info']['page'] = $page;
		$this->generateData($em, $channel->getId(), $data);
		
		// Do page stuff
		$data['trigger']['page']=true;
		$this->insertPage($em, $data);
		$data['info']['title'] = $data['page']['title'];
		if($channel->getId() == $data['page']['channel']){
			return $this->display($data);
		}
	}
	
	public function galleryAction($galleryid){
		$em = $this->getDoctrine()->getEntityManager();
		$domain = $em->getRepository('FlouVideoManagerBundle:Domain')->findListByDomain($this->getRequest()->getHost());
		$channel = $domain->getChannel();
		$data['info']['page'] = Page::GALLERY;
		$this->generateData($em, $channel->getId(), $data);
		
		// do gallery stuff
		$data['trigger']['gallery']=true;
		$data['info']['gallery'] = $galleryid;
		$this->insertGallery($em, $data);
		$data['info']['title'] = $data['gallery']['title'];
		
		return $this->display($data);
	}
	
	public function photoAction($photoid){
		$em = $this->getDoctrine()->getEntityManager();
		$domain = $em->getRepository('FlouVideoManagerBundle:Domain')->findListByDomain($this->getRequest()->getHost());
		$channel = $domain->getChannel();
		$data['info']['page'] = Page::PHOTO;
		$this->generateData($em, $channel->getId(), $data);
		
		//do photo stuff
		$data['trigger']['photo']=true;
		$data['info']['photo'] = $photoid;
		$this->insertPhoto($em, $data);
		$data['info']['title'] = $data['photo']['title'];
		
		return $this->display($data);
	}
	
	public function playlistAction($playlistid)
	{
		$em = $this->getDoctrine()->getEntityManager();
		$domain = $em->getRepository('FlouVideoManagerBundle:Domain')->findListByDomain($this->getRequest()->getHost());
		$channel = $domain->getChannel();
		$data['info']['page'] = Page::VIDEO;
		$this->generateData($em, $channel->getId(), $data);
		
		// Do playlist stuff
		$data['trigger']['playlist']=true;
		$data['info']['playlist'] = $playlistid;
		$this->insertPlaylist($em, $data, $playlistid);
		$data['info']['title'] = $data['playlist']['title'];
	
		return $this->display($data);
	}
	
	public function videoAction($video)
	{
		$em = $this->getDoctrine()->getEntityManager();
		$domain = $em->getRepository('FlouVideoManagerBundle:Domain')->findListByDomain($this->getRequest()->getHost());
		$channel = $domain->getChannel();
		$data['info']['page'] = Page::VIDEO;
		$this->generateData($em, $channel->getId(), $data);
		
		// Do video stuff
		$data['trigger']['video']=true;
		$data['info']['video'] = $video;
		$this->insertVideo($em, $data);
		$data['info']['title'] = $data['video']['title'];
		
		if($channel->getId() == $data['video']['channel']){
			return $this->display($data);
		}
	}
	
	public function contactAction(Request $request){
		$em = $this->getDoctrine()->getEntityManager();
		$domain = $em->getRepository('FlouVideoManagerBundle:Domain')->findListByDomain($this->getRequest()->getHost());
		$channel = $domain->getChannel();
		$data['info']['page'] = Page::OTHER;
		$this->generateData($em, $channel->getId(), $data);
		
		// Do contact stuff
		$data['trigger']['contact']=true;
		$contactdata = new Contact();
		$form = $this->createForm(new ContactType(), $contactdata);
		$done = false;
		if ($request->getMethod() == 'POST') {
			$form->bindRequest($request);
			 
			if ($form->isValid()) {
				//Send mail
				if($channel->getContactemail() != ''){
					$message = \Swift_Message::newInstance()
					->setSubject('WebTV-Anfrage: '.$contactdata->subject)
					->setFrom($this->container->getParameter('mailer_user'))
					->setTo($channel->getContactemail())
					->setBody($this->renderView('FlouVideoManagerBundle:Contact:email.html.twig', array('contact' => $contactdata)), 'text/html')
					;
					$this->get('mailer')->send($message);
				}
				$done = true;
			}
		}
		
		$data['info']['title'] = "Kontakt";
		$data['contact'] = $this->renderView('FlouVideoManagerBundle:Contact:contact.html.twig', array('form' => $form->createView(), 'done' => $done,));

		return $this->display($data);
	}
	
	public static function insertChannel($em, &$data)
	{
		$data['channel'] = $em->getRepository('FlouVideoManagerBundle:Channel')->findUnitedFirstByChannelId($data['info']['channel']);
		$data['trigger']['language_de'] = $data['channel']['language_de'];
		$data['trigger']['language_en'] = $data['channel']['language_en'];
		$data['trigger']['language_fr'] = $data['channel']['language_fr'];
	}
	
	public static function insertDesign($em, &$data)
	{
		$data['design'] = $em->getRepository('FlouVideoManagerBundle:Design')->findUnitedFirstByChannelId($data['info']['channel']);
		$data['info']['template'] = $data['design']['template'];
	}
	
	public static function insertPhoto($em, &$data){
		$data['photo'] = $em->getRepository('FlouVideoManagerBundle:Photo')->findUnitedFirstById($data['info']['photo'], $data['info']['language']);
	}
	
	public static function insertPlaylist($em, &$data)
	{
		if($data['info']['playlist'] == 0){
			$data['playlist'] = array();
			$data['playlist']['title'] = 'TV';
			$data['playlist']['id'] = 0;
			$data['playlist']['videos'] = $em->getRepository('FlouVideoManagerBundle:Video')->findUnitedListByChannelId($data['info']['channel'], $data['info']['language']);
			
		}else{
			$data['playlist'] = $em->getRepository('FlouVideoManagerBundle:Playlist')->findUnitedFirstByPlaylistId($data['info']['playlist'], $data['info']['language']);
			$data['playlist']['videos'] = $em->getRepository('FlouVideoManagerBundle:Video')->findUnitedListByPlaylistId($data['info']['playlist'], $data['info']['language']);
		}
	}
	
	public static function insertGallery($em, &$data)
	{
		$data['gallery'] = $em->getRepository('FlouVideoManagerBundle:Gallery')->findUnitedFirstByGalleryId($data['info']['gallery'], $data['info']['language']);
		$data['gallery']['photos'] = $em->getRepository('FlouVideoManagerBundle:Photo')->findUnitedListByGalleryId($data['info']['gallery'], $data['info']['language']);
	}
	
	
	public static function insertWidgets($em, &$data, $container){
		$widgetinfos = WidgetController::getWidgetInfo();
		$data['info']['widget1'] = false;
		$data['info']['widget2'] = false;
		$data['info']['widget3'] = false;
		$data['info']['widget4'] = false;
		$data['widgetgroups'] = array();
		$data['widgetgroups']['1'] = array();
		$data['widgetgroups']['2'] = array();
		$data['widgetgroups']['3'] = array();
		$data['widgetgroups']['4'] = array();
		
		foreach($widgetinfos as $widgetinfo){
			
			$get = $em->getRepository($widgetinfo['namespace'])->findListByChannelId($data['info']['channel'], $data['info']['page'], $data['info']['language']);
			
			//print_r($get);
			
			foreach($get as $item){
				$itemarray = array( 'position' => $item['position'],
									'content' => $item[0]->drawWidget($container, $data['info']['channel'], $data['info']['language']),
									'name' => $item['title'],
									'orderrank' => $item[0]->getOrderrank(),
									'type' => $item[0]->type());
				
				$data['trigger']['widget'.$itemarray['position']] = true;
				$data['widgetgroups'][$itemarray['position']][] = $itemarray;
			}
		}
		
		usort($data['widgetgroups']['1'], array('Flou\VideoManagerBundle\Controller\TvController','widgetCmp'));
		usort($data['widgetgroups']['2'], array('Flou\VideoManagerBundle\Controller\TvController','widgetCmp'));
		usort($data['widgetgroups']['3'], array('Flou\VideoManagerBundle\Controller\TvController','widgetCmp'));
		usort($data['widgetgroups']['4'], array('Flou\VideoManagerBundle\Controller\TvController','widgetCmp'));
	}
	
	public static function widgetCmp( $a, $b )
	{
		if(  $a['orderrank'] ==  $b['orderrank'] ){
			return 0 ;
		}
		return ($a['orderrank'] < $b['orderrank']) ? -1 : 1;
	}
	
	public static function insertMenu($em, &$data)
	{
		$pages = $em->getRepository('FlouVideoManagerBundle:Page')->findUnitedListByChannelId($data['info']['channel'], $data['info']['language']);
		$data['trigger']['menu1'] = false;
		$data['trigger']['menu2'] = false;
		$data['trigger']['menu3'] = false;
		$data['trigger']['menu4'] = false;
		$data['menugroups'] = array();
		$data['menugroups']['1'] = array();
		$data['menugroups']['2'] = array();
		$data['menugroups']['3'] = array();
		$data['menugroups']['4'] = array();
		$data['menuitems'] = array();
		
		
		
		foreach($pages as $item )
		{
			$menuitem = null;
			// normal menuitem
			$data['menuitems'][] = $item;
			
			if($item['menugroup'] != '')
			{
				if(!array_key_exists($item['menugroup'], $data['menugroups'][$item['position']]))
				{
					$data['menugroups'][$item['position']][$item['menugroup']] = array();
					$data['menugroups'][$item['position']][$item['menugroup']]['items'] = array();
					$data['menugroups'][$item['position']][$item['menugroup']]['_link'] = false;
				}
				
				$data['menugroups'][$item['position']][$item['menugroup']]['_items'] = true;
				$data['menugroups'][$item['position']][$item['menugroup']]['items'][] = $item;
			}
			else{
				if(!array_key_exists($item['title'], $data['menugroups'][$item['position']]))
				{
					$data['menugroups'][$item['position']][$item['title']] = array();
					$data['menugroups'][$item['position']][$item['title']]['items'] = array();
					$data['menugroups'][$item['position']][$item['title']]['_items'] = false;
				}
				$data['menugroups'][$item['position']][$item['title']]['_link'] = true;
				$data['menugroups'][$item['position']][$item['title']]['link'] = $item;
			}
			
			$data['trigger']['menu'.$item['position']] = true;
		}
	}
	
	public static function insertPage($em, &$data)
	{
		$data['page'] = $em->getRepository('FlouVideoManagerBundle:Page')->findUnitedFirstById($data['info']['page'], $data['info']['language']);
	}
	
	public static function insertVideo($em, &$data)
	{
		$data['video'] = $em->getRepository('FlouVideoManagerBundle:Video')->findUnitedFirstById($data['info']['video'], $data['info']['language']);
	}
	
	public static function insertTemplate(&$data)
	{
		switch($data['info']['template'])
		{
			case 1:
				$data['info']['usertemplate'] = 'FlouVideoManagerBundle:Usertemplates:template.'.$data['info']['channel'].'.html.twig';
				break;
			case 2:
				//$data['info']['usertemplate'] = 'FlouVideoManagerBundle:Tv:test.html.twig';
				$data['info']['usertemplate'] = 'FlouVideoManagerBundle:Tv:noirdesign.html.twig';
				break;
			case 3:
				$data['info']['usertemplate'] = 'FlouVideoManagerBundle:Tv:printempsdesign.html.twig';
				break;
			default:
				$data['info']['usertemplate'] = 'noirdesign.html.twig';
				break;
		}
	}
}