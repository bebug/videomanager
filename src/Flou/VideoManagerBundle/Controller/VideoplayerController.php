<?php 

namespace Flou\VideoManagerBundle\Controller;

use Flou\VideoManagerBundle\DependencyInjection\FlouVideoManagerExtension;

use Flou\VideoManagerBundle\FlouVideoManagerBundle;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


/**
 * @Template()
 */
class VideoplayerController extends Controller
{
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
	
	public function videoAction($id)
	{
		$em = $this->getDoctrine()->getEntityManager();
		
		$data['video'] = $em->getRepository('FlouVideoManagerBundle:Video')->findUnitedPlayinfoFirstById($id, $this->getLanguage());
		$this->readgets($data);
		
		
		return $this->render('FlouVideoManagerBundle:Videoplayer:video.html.twig', $data
		);
	}
	
	public function channelAction($id)
	{
		$em = $this->getDoctrine()->getEntityManager();
		$data['playlist'] = array();
		$data['playlist']['videos'] = $em->getRepository('FlouVideoManagerBundle:Video')->findUnitedPlayinfoListByChannelId($id, $this->getLanguage());
		$this->readgets($data);
		
		return $this->render('FlouVideoManagerBundle:Videoplayer:video.html.twig', $data
		);
	}
	
	public function playlistAction($id)
	{
		$em = $this->getDoctrine()->getEntityManager();
		$data['playlist'] = array();
		$data['playlist']['videos'] = $em->getRepository('FlouVideoManagerBundle:Video')->findUnitedPlayinfoListByPlaylistId($id, $this->getLanguage());
		$this->readgets($data);
		
		return $this->render('FlouVideoManagerBundle:Videoplayer:video.html.twig', $data
		);
	}
	
	public function readgets(&$data)
	{
		$data['autostart'] = $this->getRequest()->get('autostart');
		$data['html5'] = $this->getRequest()->get('html5');
	}
}