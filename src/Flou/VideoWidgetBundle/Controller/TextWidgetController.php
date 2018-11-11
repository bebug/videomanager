<?php

namespace Flou\VideoWidgetBundle\Controller;

use Flou\VideoManagerBundle\Controller\WidgetController;
use Flou\VideoManagerBundle\Controller\HelperController;

use Flou\VideoWidgetBundle\Entity\TextWidget;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Flou\VideoManagerBundle\Entity\Description;
use Flou\VideoManagerBundle\Entity\Title;
use Flou\VideoWidgetBundle\Form\Type\TextWidgetType;

class TextWidgetController extends Controller
{
	public function newAction(Request $request)
    {
    	$em = $this->getDoctrine()->getEntityManager();
    	$user = $this->get('security.context')->getToken()->getUser();
    	$widget = new TextWidget();
    	$widget->setTitle(new Title());
    	$form = $this->createForm(new TextWidgetType($user->getChannel()->getId()), $widget);
    	
    	
    	if ($request->getMethod() == 'POST') {
    		$form->bindRequest($request);

    		if ($form->isValid()) {
    			
    			$channel = $user->getChannel();
    			
    			if($widget->getOrderrank() == null)
    			{
    				$widget->setOrderrank(0);
    			}
    			$widget->setChannel($channel);
    			
    			$em->persist($channel);
    			$em->persist($widget);
    			$em->persist($widget->getTitle());
    			$em->persist($widget->getDescription());
    			$em->flush();
    			 
    			return $this->redirect($this->generateUrl('widget_list'));
    		}
    	}
    	
    	HelperController::initTinymce($this->container->getParameter('upload.dir.mce').'/files/'.$user->getId(), $this->container->getParameter('upload.dir.absolute').'/files/'.$user->getId(), $this->get("session"));
    	 
    	return $this->render('FlouVideoWidgetBundle:TextWidget:edit.html.twig', array(
    			'form' => $form->createView(),
    	));
    }
    
    public function editAction(Request $request, $id)
    {
    	// get em
    	$em = $this->getDoctrine()->getEntityManager();
    	$user = $this->get('security.context')->getToken()->getUser();
    	$widget = $em->getRepository('FlouVideoWidgetBundle:TextWidget')->findOneById($id);
    	 
    	if($widget == null || $widget->getChannel() !== $user->getChannel())
    	{
    		return $this->createNotFoundException("Not found");
    	}
    	else
    	{
    		 
    		$form = $this->createForm(new TextWidgetType($user->getChannel()->getId()), $widget);
    		 
    		if ($request->getMethod() == 'POST') {
    			$form->bindRequest($request);
    
    			if ($form->isValid()) {
    
    				$em->flush();
    
    				return $this->redirect($this->generateUrl('widget_list'));
    			}
    		}
    		 
    		HelperController::initTinymce($this->container->getParameter('upload.dir.mce').'/files/'.$user->getId(), $this->container->getParameter('upload.dir.absolute').'/files/'.$user->getId(), $this->get("session"));
    		
    		return $this->render('FlouVideoWidgetBundle:TextWidget:edit.html.twig', array(
    			'form' => $form->createView(),
    		));
    	}
    }
    
    public function deleteAction($id)
    {
    	// get em
    	$em = $this->getDoctrine()->getEntityManager();
    	$user = $this->get('security.context')->getToken()->getUser();
    	$widget = $em->getRepository('FlouVideoWidgetBundle:TextWidget')->findOneById($id);
    	 
    	if($widget == null || $widget->getChannel() !== $user->getChannel())
    	{
    		return $this->createNotFoundException("Not found");
    	}
    	else {

    		$em->remove($widget->getTitle());
    		$em->remove($widget->getDescription());
    		$em->remove($widget);
    		$em->flush();
    			
    		return $this->redirect($this->generateUrl('widget_list'));
    	}
    }
}
