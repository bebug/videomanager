<?php

namespace Flou\VideoManagerBundle\Controller;

use Flou\VideoManagerBundle\FlouVideoManagerBundle;
use Flou\VideoManagerBundle\Entity\Page;
use Flou\VideoManagerBundle\Form\Type\PageType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class PageController extends Controller
{
    public function newAction(Request $request)
    {
    	
    	$page = new Page();
    	$form = $this->createForm(new PageType(), $page);
    	
    	if ($request->getMethod() == 'POST') {
    		$form->bindRequest($request);

    		if ($form->isValid()) {
    			// get em
    			$em = $this->getDoctrine()->getEntityManager();
    			
    			$user = $em->getRepository('FlouVideoManagerBundle:User')->findOneById($this->get('security.context')->getToken()->getUser()->getId());
    			$channel = $user->getChannel();
    			$channel->addPage($page);
    			
    			if($page->getOrderrank() == null)
    			{
    				$page->setOrderrank(0);
    			}
    			
    			$em->persist($channel);
    			$em->persist($page);
    			$em->persist($page->getTitle());
    			$em->persist($page->getGroup());
    			$em->persist($page->getDescription());
    			$em->flush();
    			 
    			return $this->redirect($this->generateUrl('page_list'));
    		}
    	}
    	 
    	return $this->render('FlouVideoManagerBundle:Page:edit.html.twig', array(
    			'form' => $form->createView(),
    	));
    }
    
    public function editAction(Request $request, $pageid)
    {
    	// get em
    	$em = $this->getDoctrine()->getEntityManager();
    	$user = $this->get('security.context')->getToken()->getUser();
    	$page = $em->getRepository('FlouVideoManagerBundle:Page')->findOneById($pageid);
    	
    	if($page == null || $page->getChannel() !== $user->getChannel())
    	{
    		return $this->createNotFoundException("Not found");
    	}
    	else
    	{
    	
    	$form = $this->createForm(new PageType(), $page);
    	
    	if ($request->getMethod() == 'POST') {
    		$form->bindRequest($request);
    		
    		if ($form->isValid()) {
    			 
    			$em->flush();
    		
    			return $this->redirect($this->generateUrl('page_list'));
    		}
    	}
    	
    	return $this->render('FlouVideoManagerBundle:Page:edit.html.twig', array(
    			'form' => $form->createView(),
    	));
    	}
    }
    
    public function listAction()
    {
    	$pages = $this->get('security.context')->getToken()->getUser()->getChannel()->getPages();
    	
    	return $this->render('FlouVideoManagerBundle:Page:list.html.twig', array(
    			'pages' => $pages,
    	));
    }
    
    public function deleteAction($pageid)
    {
    	// get em
    	$em = $this->getDoctrine()->getEntityManager();
    	$user = $this->get('security.context')->getToken()->getUser();
    	$page = $em->getRepository('FlouVideoManagerBundle:Page')->findOneById($pageid);
    	
    	if($page == null || $page->getChannel() !== $user->getChannel())
    	{
    		return $this->createNotFoundException("Not found");
    	}else {
    		if($user->getChannel()->getDefaultpage() === $page){
    			$this->get('session')->setFlash('notice', 'Seite "'.$page->getTitle()->getTitleDe().'" wurde als Startseite definiert. Löschen nicht möglich!');
    		}
    		else{
    			$em->remove($page->getTitle());
    			$em->remove($page->getGroup());
    			$em->remove($page->getDescription());
    			$em->remove($page);
    			$em->flush();
    		}
    		return $this->redirect($this->generateUrl('page_list'));
    	}
    }
}