<?php

namespace Flou\VideoManagerBundle\Controller;

use Flou\VideoManagerBundle\FlouVideoManagerBundle;
use Flou\VideoManagerBundle\Entity\Channel;
use Flou\VideoManagerBundle\Entity\Description;
use Flou\VideoManagerBundle\Form\Type\ChannelType;
use Flou\VideoManagerBundle\Form\Type\ChannelHeadType;
use Flou\VideoManagerBundle\Form\Type\ChannelMenuType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class AdminController extends Controller
{
    /**
     * @Template()
     */
    public function updateAction()
    {
    	// do update shit here!
    	$messages = null;
    	
    	$em = $this->getDoctrine()->getEntityManager();
    	$videos = $em->getRepository('FlouVideoManagerBundle:Video')->findAll();
    	
    	foreach($videos as $video)
    	{
    		if($video->getShortdescription() == null)
    		{
    			$messages[] = 'video '.$video->getId().' has no shortdescription!';
    			$video->setShortdescription(new Description());
    			
    			$em->persist($video);
    			$em->persist($video->getShortdescription());
    			$em->flush();
    			
    			$messages[] = 'created description for video '.$video->getId();
    		}
    	}
    	
    	if(count($messages) < 1)
    	{
    		$messages[] = 'Nothing updated!';
    	}
    	
    	$data['update']['messages'] = $messages;
    	
    	
    	return $this->render('FlouVideoManagerBundle:Admin:update.html.twig', $data);
    }
    
    public function getuserAction()
    {
    	$em = $this->getDoctrine()->getEntityManager();
    	
    	$userid = $this->getRequest()->get('id');
    	
    	
    	$data['users'] = $em->getRepository("FlouVideoManagerBundle:User")->findAll();
    	
    	return $this->render('FlouVideoManagerBundle:Admin:getuser.html.twig', $data);
    }
}