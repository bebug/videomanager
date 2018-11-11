<?php

namespace Flou\VideoManagerBundle\Controller;

use Symfony\Component\HttpFoundation\Session\Storage\Handler\NativeSessionHandler;

use Flou\VideoManagerBundle\FlouVideoManagerBundle;
use Flou\VideoManagerBundle\Entity\Page;
use Flou\VideoManagerBundle\Entity\Title;
use Flou\VideoManagerBundle\Form\Type\PageType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\HttpFoundation\Session\Storage\MockFileSessionStorage;
use Symfony\Component\HttpFoundation\Session\Session;

class PageController extends Controller
{
    public function newAction(Request $request)
    {
    	
    	$page = new Page();
    	$page->setHyperlink($this->getRequest()->get('hyperlink'));
    	$page->setTitle(new Title());
    	$page->getTitle()->setTitleDe($this->getRequest()->get('titlede'));
    	$page->getTitle()->setTitleEn($this->getRequest()->get('titleen'));
    	$page->getTitle()->setTitleFr($this->getRequest()->get('titlefr'));
    	$form = $this->createForm(new PageType(), $page);
    	$em = $this->getDoctrine()->getEntityManager();
    	$user = $em->getRepository('FlouVideoManagerBundle:User')->findOneById($this->get('security.context')->getToken()->getUser()->getId());
    	
    	if ($request->getMethod() == 'POST') {
    		$form->bindRequest($request);

    		if ($form->isValid()) {
    			
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
    	
    	HelperController::initTinymce($this->container->getParameter('upload.dir.mce').'/files/'.$user->getId(), $this->container->getParameter('upload.dir.absolute').'/files/'.$user->getId(),$this->get("session"));
    	
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
    	
    	
    	
    	/*$session  = $this->get("session");
    	$mocksession = new Session(new MockFileSessionStorage());
    	$mocksession->setId($session->getId());
    	$mocksession->start();
    	print_r($mocksession);
    	$mocksession->set('mc_LoggedIn', true);
    	$mocksession->set('mc_rootpath', $this->container->getParameter('upload.dir.mce').'/files/'.$user->getId());
    	$mocksession->set('mc_path', $this->container->getParameter('upload.dir.mce').'/files/'.$user->getId());
    	$mocksession->save();*/
    	//echo $session->getId();
    	//print_r($_SESSION);
    	//$handler = new \SessionHandler();
    	//print_r($handler->read($session->getId()));
    	
    	//print_r(\SessionHandler::read($session->getId()));
    	
    	//session_start();
    	// $session->set('LoggedIn', true);
    	// $session->set('pennis', 'hallo');
    	 //$_SESSION['mc_isLoggedIn'] = 'mukmuk';
    	 //echo $_SESSION['pennis'];
    	//echo $_SESSION['mc_isLoggedIn'];
    	//$_SESSION['mc_isLoggedIn'] = 'juhuhuhuhu';
    	//$_SESSION['mc_rootpath'] = '';
    	//$_SESSION['mc_path'] = '';
    	
    	HelperController::initTinymce($this->container->getParameter('upload.dir.mce').'/files/'.$user->getId(), $this->container->getParameter('upload.dir.absolute').'/files/'.$user->getId(), $this->get("session"));
    	
    	return $this->render('FlouVideoManagerBundle:Page:edit.html.twig', array(
    			'form' => $form->createView(),
    	));
    	}
    }
    
    public function listAction()
    {
    	$em = $this->getDoctrine()->getEntityManager();
    	$user = $this->get('security.context')->getToken()->getUser();
    	
    	if ($this->getRequest()->getMethod() === 'POST') {
    		if($this->getRequest()->get('changeposition')){
    			$position = $em->getRepository('FlouVideoManagerBundle:Pageposition')->find($this->getRequest()->get('positionid'));
    		}
    
    		
    		$selectedpages = $this->getRequest()->get('selectedpage');
    		
    		if($selectedpages != null){
	    		foreach ($selectedpages as &$selectedpage)
	    		{
	    			$page = $em->getRepository('FlouVideoManagerBundle:Page')->find($selectedpage);
	    			
	    			if($this->getRequest()->get('changeposition'))
	    			{
	    				$page->setPageposition($position);
	    			}
	    			
	    			if($this->getRequest()->get('changegroup_de'))
	    			{
	    				$page->getGroup()->setTitleDe($this->getRequest()->get('groupname_de'));
	    				$em->persist($page->getGroup());
	    			}
	    			
	    			if($this->getRequest()->get('changegroup_en'))
	    			{
	    				$page->getGroup()->setTitleEn($this->getRequest()->get('groupname_en'));
	    				$em->persist($page->getGroup());
	    			}
	    			
	    			if($this->getRequest()->get('changegroup_fr'))
	    			{
	    				$page->getGroup()->setTitleFr($this->getRequest()->get('groupname_fr'));
	    				$em->persist($page->getGroup());
	    			}
	    			
	    			$em->persist($page);
	    		}
    		}
    		$em->flush();
    	}
    	
    	//$pages = $user->getChannel()->getPages();
    	
    	$query = $em
    	->createQuery('
    			SELECT p
    			FROM FlouVideoManagerBundle:Page p
    			JOIN p.channel c
    			JOIN p.pageposition pos
    			JOIN p.group g
    			WHERE c.id = :id
    			ORDER BY pos.position ASC, g.title_de ASC, p.orderrank ASC'
    	)->setParameter('id', $user->getChannel()->getId());
    	$pages = $query->getResult();
    	
    	$positions = $em->getRepository('FlouVideoManagerBundle:Pageposition')->findall();
    	
    	return $this->render('FlouVideoManagerBundle:Page:list.html.twig', array(
    			'pages' => $pages, 'positions' => $positions
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
    			// delete widgets
    			$widgetinfos = WidgetController::getWidgetInfo();    			
    			foreach($widgetinfos as $widgetinfo){
    				$widgets = $em->getRepository($widgetinfo['namespace'])->findListByChannelId($user->getChannel()->getId(), -1);
    				foreach($widgets as $item){
						echo "----";
    					if($item[0]->getPage() === $page)
    					{
    						$em->remove($item[0]->getTitle());
    						$em->remove($item[0]);
    					}
    				}
    			}
    			
    			$em->remove($page->getTitle());
    			$em->remove($page->getGroup());
    			$em->remove($page->getDescription());
    			$em->remove($page);
    			$em->flush();
    		}
    		return $this->listAction();
    	}
    }
}