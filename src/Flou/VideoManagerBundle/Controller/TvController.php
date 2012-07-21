<?php 

namespace Flou\VideoManagerBundle\Controller;

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
	//protected $templateloader;
	//protected $twig;
	
	public function __construct()
	{
		// load new twig environment. this is 
		/*$loader = new \Twig_Loader_Filesystem(array(__DIR__.'/../Usertemplates', __DIR__.'/../Resources/views/Tv'));
		$this->twig = new \Twig_Environment($loader, array(
				'cache' => __DIR__.'/../../../../app/cache/twig',
				'auto_reload' => true,
		));
		
		$this->twig->addFunction('lighten', new \Twig_Function_Function('Flou\VideoManagerBundle\Twig\FlouExtension::lighten'));
		$this->twig->addFunction('darken', new \Twig_Function_Function('Flou\VideoManagerBundle\Twig\FlouExtension::darken'));
		$this->twig->addFunction('gradient', new \Twig_Function_Function('Flou\VideoManagerBundle\Twig\FlouExtension::gradient'));
		
		$this->templateloader = $this->twig->loadTemplate('templateloader.html.twig');*/
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
		$data['info']['language'] = $this->getLanguage();
		$data['info']['channel'] = $channel;
		//$data['info']['assetserver'] = $this->container->getParameter('server.web.url');
		$this->insertChannel($em, $data);
		$this->insertDesign($em, $data);
		$this->insertMenu($em, $data);
		$this->insertTemplate($data);
		
		//set additional trigger
		$data['info']['menucontent'] = ($data['channel']['menu'] != "");
		$data['info']['headercontent'] = ($data['channel']['header'] != "");
	}
	
	public function defaultAction($language)
	{
		$em = $this->getDoctrine()->getEntityManager();
		$domain = $em->getRepository('FlouVideoManagerBundle:Domain')->findListByDomain($this->getRequest()->getHost());
		
		$channel = $domain->getChannel();
		//print_r($channel->getId());
		$session = $this->getRequest()->getSession();
		$session->set('language', $language);
		
		$data['info']['language'] = $this->getLanguage();
		$data = $this->generateData($em, $channel->getId(), $data);
			
		$defaultpage = $channel->getDefaultpage();
		if($defaultpage == null) return $this->redirect($this->generateUrl('tv_playlist', array('channel' => $channel->getId())));
		else if($defaultpage->getHyperlink() != ''){
			return $this->redirect($defaultpage->getHyperlink());
		}
		else {
			return $this->redirect($this->generateUrl('tv_page', array('page' => $defaultpage->getID())));
		}
	}
	
	public function pageAction($page)
	{
		//echo $this->getRequest()->getHost();
		$em = $this->getDoctrine()->getEntityManager();
		$domain = $em->getRepository('FlouVideoManagerBundle:Domain')->findListByDomain($this->getRequest()->getHost());
		$channel = $domain->getChannel();
		
		$data['info']['language'] = $this->getLanguage();
		$data['info']['page'] = $page;
		
		$this->insertPage($em, $data);
		$this->generateData($em, $data['page']['channel'], $data);

		$data['info']['title'] = $data['page']['title'];
		if($channel->getId() == $data['page']['channel']){
			return $this->display($data);
		}
	}
	
	public function playlistAction()
	{
		$em = $this->getDoctrine()->getEntityManager();
		$domain = $em->getRepository('FlouVideoManagerBundle:Domain')->findListByDomain($this->getRequest()->getHost());
		$channel = $domain->getChannel();
		$data['info']['language'] = $this->getLanguage();
		$this->generateData($em, $channel->getId(), $data);
		$this->insertPlaylist($em, $data);
		$data['info']['title'] = 'TV';
		
		return $this->display($data);
	}
	
	public function videoAction($video)
	{
		$em = $this->getDoctrine()->getEntityManager();
		$domain = $em->getRepository('FlouVideoManagerBundle:Domain')->findListByDomain($this->getRequest()->getHost());
		$channel = $domain->getChannel();
		
		$data['info']['language'] = $this->getLanguage();
		
		
		$data['info']['video'] = $video;
		$this->insertVideo($em, $data);
		$data['info']['title'] = $data['video']['title'];
		
		$this->generateData($em, $data['video']['channel'], $data);
		if($channel->getId() == $data['video']['channel']){
			return $this->display($data);
		}
	}
	
	public static function insertChannel($em, &$data)
	{
		$data['channel'] = $em->getRepository('FlouVideoManagerBundle:Channel')->findUnitedFirstByChannelId($data['info']['channel']);
	}
	
	public static function insertDesign($em, &$data)
	{
		$data['design'] = $em->getRepository('FlouVideoManagerBundle:Design')->findUnitedFirstByChannelId($data['info']['channel']);
		$data['info']['template'] = $data['design']['template'];
	}
	
	public static function insertPlaylist($em, &$data)
	{
		$data['playlist'] = $em->getRepository('FlouVideoManagerBundle:Video')->findUnitedListByChannelId($data['info']['channel'], $data['info']['language']);
	}
	
	public static function insertMenu($em, &$data)
	{
		$pages = $em->getRepository('FlouVideoManagerBundle:Page')->findUnitedListByChannelId($data['info']['channel'], $data['info']['language']);
		$data['info']['menu1'] = false;
		$data['info']['menu2'] = false;
		$data['info']['menu3'] = false;
		$data['info']['menu4'] = false;
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
				}
				$data['menugroups'][$item['position']][$item['menugroup']][] = $item;
			}
			
			$data['info']['menu'.$item['position']] = true;
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
				$data['info']['usertemplate'] = 'FlouVideoManagerBundle:Tv:noirdesign.html.twig';
				break;
			default:
				$data['info']['usertemplate'] = 'noirdesign.html.twig';
				break;
		}
	}
}