<?php

namespace Flou\VideoManagerBundle\Controller;

use Flou\VideoManagerBundle\FlouVideoManagerBundle;
use Flou\VideoManagerBundle\Entity\Channel;
use Flou\VideoManagerBundle\Form\Type\ChannelType;
use Flou\VideoManagerBundle\Form\Type\ChannelHeadType;
use Flou\VideoManagerBundle\Form\Type\ChannelMenuType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\HttpFoundation\Session\Storage\MockFileSessionStorage;
use Symfony\Component\HttpFoundation\Session\Session;

class HelperController extends Controller
{
	public static function initTinymce($relpath, $absolutepath, $session)
	{
		HelperController::createPath($absolutepath);
		
		$mocksession = new Session(new MockFileSessionStorage());
		$mocksession->setId($session->getId());
		$mocksession->start();
		$mocksession->set('mc_LoggedIn', true);
		$mocksession->set('mc_rootpath', $relpath);
		$mocksession->set('mc_path', $relpath);
		$mocksession->save();
	}
	
	public static function createPath($path){
		if(!file_exists($path))
		{
			mkdir($path);
		}
	}
	
	public static function rrmdir($path)
	{
		return is_file($path)?
		@unlink($path):
		array_map('Flou\VideoManagerBundle\Controller\HelperController::rrmdir',glob($path.'/*'))==@rmdir($path)
		;
	}
}