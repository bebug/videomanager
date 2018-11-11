<?php

namespace Flou\VideoWidgetBundle\Controller;

use Flou\VideoWidgetBundle\Entity\PlaylistWidget;

use Flou\VideoManagerBundle\Controller\WidgetController;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Flou\VideoManagerBundle\Entity\Title;
use Flou\VideoWidgetBundle\Form\Type\PlaylistWidgetType;

class PlaylistWidgetController extends Controller
{
	public function newAction(Request $request)
	{
		$widget = new PlaylistWidget();
		$widget->setTitle(new Title());
		$em = $this->getDoctrine()->getEntityManager();
		$user = $this->get('security.context')->getToken()->getUser();
		
		$form = $this->createForm(new PlaylistWidgetType($user->getChannel()->getId()), $widget);
		
		 
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
				$em->flush();
	
				return $this->redirect($this->generateUrl('widget_list'));
			}
		}
		 
		return $this->render('FlouVideoWidgetBundle:PlaylistWidget:edit.html.twig', array(
				'form' => $form->createView(), 'widgetinfos' => WidgetController::getWidgetInfo()
		));
	}
	
	public function editAction(Request $request, $id)
	{
		// get em
		$em = $this->getDoctrine()->getEntityManager();
		$user = $this->get('security.context')->getToken()->getUser();
		$widget = $em->getRepository('FlouVideoWidgetBundle:PlaylistWidget')->findOneById($id);
	
		if($widget == null || $widget->getChannel() !== $user->getChannel())
		{
			return $this->createNotFoundException("Not found");
		}
		else
		{
			 
			$form = $this->createForm(new PlaylistWidgetType($user->getChannel()->getId()), $widget);
			 
			if ($request->getMethod() == 'POST') {
				$form->bindRequest($request);
	
				if ($form->isValid()) {
	
					$em->flush();
	
					return $this->redirect($this->generateUrl('widget_list'));
				}
			}
			 
			return $this->render('FlouVideoWidgetBundle:PlaylistWidget:edit.html.twig', array(
					'form' => $form->createView(), 'widgetinfos' => WidgetController::getWidgetInfo()
			));
		}
	}
	
	public function deleteAction($id)
	{
		// get em
		$em = $this->getDoctrine()->getEntityManager();
		$user = $this->get('security.context')->getToken()->getUser();
		$widget = $em->getRepository('FlouVideoWidgetBundle:PlaylistWidget')->findOneById($id);
	
		if($widget == null || $widget->getChannel() !== $user->getChannel())
		{
			return $this->createNotFoundException("Not found");
		}
		else {
	
			$em->remove($widget->getTitle());
			$em->remove($widget);
			$em->flush();
			 
			return $this->redirect($this->generateUrl('widget_list'));
		}
	}
}