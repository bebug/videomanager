<?php 

namespace Flou\VideoManagerBundle\Controller;

use Flou\VideoManagerBundle\FlouVideoManagerBundle;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

define("FFMPEGURI", "C:/Tools/ffmpeg/ffmpeg.exe");
define("PICNAME", "pic.png");

/**
 * @Template()
 */
class UserController extends Controller
{
	public function infoAction(Request $request)
	{
		// get em
		$em = $this->getDoctrine()->getEntityManager();
		
		
		
		$user = $this->get('security.context')->getToken()->getUser();

		$data['user'] = $user;
		$data['channel'] = $user->getChannel();
		
		return $this->render('FlouVideoManagerBundle:User:info.html.twig', $data);
	}

}