<?php

namespace Flou\VideoManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class StatisticsController extends Controller
{
    /**
     * @Template()
     */
    public function mapAction()
    {
        // get em
		$em = $this->getDoctrine()->getEntityManager();
		 
		// get user
		$user =  $em->getRepository('FlouVideoManagerBundle:User')->findOneById($this->get('security.context')->getToken()->getUser()->getId());
		$channel = $user->getChannel();
		
		return $this->render('FlouVideoManagerBundle:Statistics:map.html.twig', array(
				'piwikid' => $channel->getPiwikid(),
		));
    }
    
    public function timegraphAction()
    {
    	// get em
    	$em = $this->getDoctrine()->getEntityManager();
    		
    	// get user
    	$user =  $em->getRepository('FlouVideoManagerBundle:User')->findOneById($this->get('security.context')->getToken()->getUser()->getId());
    	$channel = $user->getChannel();
    
    	return $this->render('FlouVideoManagerBundle:Statistics:timegraph.html.twig', array(
    			'piwikid' => $channel->getPiwikid(),
    	));
    }
    
    public function sourceAction()
    {
    	// get em
    	$em = $this->getDoctrine()->getEntityManager();
    
    	// get user
    	$user =  $em->getRepository('FlouVideoManagerBundle:User')->findOneById($this->get('security.context')->getToken()->getUser()->getId());
    	$channel = $user->getChannel();
    
    	return $this->render('FlouVideoManagerBundle:Statistics:source.html.twig', array(
    			'piwikid' => $channel->getPiwikid(),
    	));
    }
    
    public function pagesAction()
    {
    	// get em
    	$em = $this->getDoctrine()->getEntityManager();
    
    	// get user
    	$user =  $em->getRepository('FlouVideoManagerBundle:User')->findOneById($this->get('security.context')->getToken()->getUser()->getId());
    	$channel = $user->getChannel();
    
    	return $this->render('FlouVideoManagerBundle:Statistics:pages.html.twig', array(
    			'piwikid' => $channel->getPiwikid(),
    	));
    }
}
