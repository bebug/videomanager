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

class ChannelController extends Controller
{
    /**
     * @Template()
     */
    public function editAction(Request $request)
    {
    	// get em
    	$em = $this->getDoctrine()->getEntityManager();
    	
    	// get user
    	$user =  $em->getRepository('FlouVideoManagerBundle:User')->findOneById($this->get('security.context')->getToken()->getUser()->getId());
    	$channel = $user->getChannel();
    	
    	if(!$channel)
    	{
    		// create new channel for user
    		$channel = new Channel();
    		$channel->setPlaylistEnabled(false);
    		$channel->setContactemail("");
    		$channel->setMaxVideos(5);
    		$channel->setPiwikid(0);
    		$channel->setUseHtml5(false);
    		$channel->setUseHyphernate(false);
    		$user->setChannel($channel);
    		 
    		$em->persist($channel);
    		$em->persist($user);
    		$em->flush();
    	}
    	
    	$form = $this->createForm(new ChannelType($channel->getId()), $channel);
    	
    	if ($request->getMethod() == 'POST') {
    		$form->bindRequest($request);
    	
    		if ($form->isValid()) {
    			$em->persist($channel);
    			$em->persist($user);
    			$em->flush();
    			
    			return $this->redirect($this->generateUrl('channel_edit'));
    		}
    	}
    	
    	HelperController::initTinymce($this->container->getParameter('upload.dir.mce').'/files/'.$user->getId(), $this->container->getParameter('upload.dir.absolute').'/files/'.$user->getId(), $this->get("session"));

 		return $this->render('FlouVideoManagerBundle:Channel:edit.html.twig', array(
 				'form' => $form->createView(),
 		));
    }
    
    public function headAction(Request $request)
    {
    	// get em
    	$em = $this->getDoctrine()->getEntityManager();
    	 
    	// get user
    	$user =  $em->getRepository('FlouVideoManagerBundle:User')->findOneById($this->get('security.context')->getToken()->getUser()->getId());
    	$channel = $user->getChannel();
    	 
    	$form = $this->createForm(new ChannelHeadType(), $channel);
    	 
    	if ($request->getMethod() == 'POST') {
    		$form->bindRequest($request);
    		 
    		if ($form->isValid()) {
    			$em->persist($channel);
    			$em->persist($user);
    			$em->flush();
    			 
    			return $this->redirect($this->generateUrl('channel_head'));
    		}
    	}
    	else if(!$channel)
    	{
    		// create new channel for user
    		$channel = new Channel();
    		$user->setChannel($channel);
    		 
    		$em->persist($channel);
    		$em->persist($user);
    		$em->flush();
    	}
    	
    	HelperController::initTinymce($this->container->getParameter('upload.dir.mce').'/files/'.$user->getId(), $this->container->getParameter('upload.dir.absolute').'/files/'.$user->getId());
    	
    	
    	return $this->render('FlouVideoManagerBundle:Channel:header.html.twig', array(
    			'form' => $form->createView(),
    	));
    }
    
    public function menuAction(Request $request)
    {
    	// get em
    	$em = $this->getDoctrine()->getEntityManager();
    
    	// get user
    	$user =  $em->getRepository('FlouVideoManagerBundle:User')->findOneById($this->get('security.context')->getToken()->getUser()->getId());
    	$channel = $user->getChannel();
    
    	$form = $this->createForm(new ChannelMenuType(), $channel);
    
    	if ($request->getMethod() == 'POST') {
    		$form->bindRequest($request);
    		 
    		if ($form->isValid()) {
    			$em->persist($channel);
    			$em->persist($user);
    			$em->flush();
    
    			return $this->redirect($this->generateUrl('channel_menu'));
    		}
    	}
    	else if(!$channel)
    	{
    		// create new channel for user
    		$channel = new Channel();
    		$user->setChannel($channel);
    		 
    		$em->persist($channel);
    		$em->persist($user);
    		$em->flush();
    	}
    
    	HelperController::initTinymce($this->container->getParameter('upload.dir.mce').'/files/'.$user->getId(), $this->container->getParameter('upload.dir.absolute').'/files/'.$user->getId());
    	
    	return $this->render('FlouVideoManagerBundle:Channel:menu.html.twig', array(
    			'form' => $form->createView(),
    	));
    }

}