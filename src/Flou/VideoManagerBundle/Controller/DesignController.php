<?php

namespace Flou\VideoManagerBundle\Controller;

use Flou\VideoManagerBundle\FlouVideoManagerBundle;
use Flou\VideoManagerBundle\Entity\Design;
use Flou\VideoManagerBundle\Form\Type\DesignType;
use Flou\VideoManagerBundle\Form\Type\DesignColorType;
use Flou\VideoManagerBundle\Form\Type\DesignTemplateType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DesignController extends Controller
{
	
	public function createDesign($em, &$channel)
	{
		// create new channel for user
		$design = new Design();
		$design->setFont($em->getRepository('FlouVideoManagerBundle:Font')->findOneBy(array()));
		$design->setTemplate($em->getRepository('FlouVideoManagerBundle:Template')->findOneBy(array('template' => 'Noir')));
		
		$channel->setDesign($design);
		
		$em->persist($design);
		$em->persist($channel);
		$em->flush();
	}
	
	public function colorAction(Request $request)
	{
		// get em
		$em = $this->getDoctrine()->getEntityManager();
		 
		// get user
		$user =  $em->getRepository('FlouVideoManagerBundle:User')->findOneById($this->get('security.context')->getToken()->getUser()->getId());
		$channel = $user->getChannel();
		$design = $channel->getDesign();
		 
		if(!$design)
		{
			$this->createDesign($em, $channel);
		}
		
		$form = $this->createForm(new DesignColorType(), $design);
		
		if ($request->getMethod() == 'POST') {
			$form->bindRequest($request);
			
			// insert empty colors regex:^[a-fA-F0-9]{6}$
			if(!preg_match('/^[a-fA-F0-9]{6}$/', $design->getHeadingcolor()))
			{
				$design->setHeadingcolor('');
			}
			if(!preg_match('/^[a-fA-F0-9]{6}$/', $design->getColor1()))
			{
				$design->setColor1('');
			}
			if(!preg_match('/^[a-fA-F0-9]{6}$/', $design->getColor2()))
			{
				$design->setColor2('');
			}
			if(!preg_match('/^[a-fA-F0-9]{6}$/', $design->getColor3()))
			{
				$design->setColor3('');
			}
			
			if(!preg_match('/^[a-fA-F0-9]{6}$/', $design->getHovercolor1()))
			{
				$design->setHovercolor1('');
			}
			if(!preg_match('/^[a-fA-F0-9]{6}$/', $design->getHovercolor2()))
			{
				$design->setHovercolor2('');
			}
			if(!preg_match('/^[a-fA-F0-9]{6}$/', $design->getHovercolor3()))
			{
				$design->setHovercolor3('');
			}
			
			if(!preg_match('/^[a-fA-F0-9]{6}$/', $design->getFontcolor1()))
			{
				$design->setFontcolor1('');
			}
			if(!preg_match('/^[a-fA-F0-9]{6}$/', $design->getFontcolor2()))
			{
				$design->setFontcolor2('');
			}
			if(!preg_match('/^[a-fA-F0-9]{6}$/', $design->getFontcolor3()))
			{
				$design->setFontcolor3('');
			}
			
			if(!preg_match('/^[a-fA-F0-9]{6}$/', $design->getHoverfontcolor1()))
			{
				$design->setHoverfontcolor1('');
			}
			if(!preg_match('/^[a-fA-F0-9]{6}$/', $design->getHoverfontcolor2()))
			{
				$design->setHoverfontcolor2('');
			}
			if(!preg_match('/^[a-fA-F0-9]{6}$/', $design->getHoverfontcolor3()))
			{
				$design->setHoverfontcolor3('');
			}
			
			if(!preg_match('/^[a-fA-F0-9]{6}$/', $design->getLinkcolor1()))
			{
				$design->setLinkcolor1('');
			}
			if(!preg_match('/^[a-fA-F0-9]{6}$/', $design->getLinkcolor2()))
			{
				$design->setLinkcolor2('');
			}
			if(!preg_match('/^[a-fA-F0-9]{6}$/', $design->getLinkcolor3()))
			{
				$design->setLinkcolor3('');
			}
			
			if ($form->isValid()) {
				$em->persist($design);
				$em->persist($channel);
				$em->flush();
				 
				return $this->redirect($this->generateUrl('design_color'));
			}
		}

		return $this->render('FlouVideoManagerBundle:Design:color.html.twig', array(
				'form' => $form->createView(),
		));
	}
	
	public function templateAction(Request $request)
	{
		// get em
		$em = $this->getDoctrine()->getEntityManager();
			
		// get user
		$user =  $em->getRepository('FlouVideoManagerBundle:User')->findOneById($this->get('security.context')->getToken()->getUser()->getId());
		$channel = $user->getChannel();
		$design = $channel->getDesign();
		
		if(!$design)
		{
			$this->createDesign($em, $channel);
		}
		
		$form = $this->createForm(new DesignTemplateType(), $design);
	
		if ($request->getMethod() == 'POST') {
			$form->bindRequest($request);
	
			if ($form->isValid()) {
				$em->persist($design);
				$em->persist($channel);
				$em->flush();
				
				$this->createTemplate($design, $channel);
					
				return $this->redirect($this->generateUrl('design_template'));
			}
		}
		
		return $this->render('FlouVideoManagerBundle:Design:template.html.twig', array(
				'form' => $form->createView(),
		));
	}
	
	
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
    	$design = $channel->getDesign();
    	
    	if(!$design)
    	{
    		createDesign($em, $channel);
    	}
    	
    	$form = $this->createForm(new DesignType(), $design);

    	if ($request->getMethod() == 'POST') {
    		$form->bindRequest($request);
    	
    		if ($form->isValid()) {
    			$em->persist($design);
    			$em->persist($channel);
    			$em->flush();
    			
    			return $this->redirect($this->generateUrl('task_success'));
    		}
    	}

 		return $this->render('FlouVideoManagerBundle:Design:edit.html.twig', array(
 				'form' => $form->createView(),
 		));
    }
    
    protected function getUploadRootDir()
    {
    	// the absolute directory path where uploaded documents should be saved
    	return __DIR__.'/../Resources/views/Usertemplates';
    }
    
    protected function replaceRiscCode($design)
    {
    	
    }
    
    function createTemplate($design, $channel)
    {
    	echo 'hallo';
    	$myFile = $this->getUploadRootDir().'/template.'.$channel->getId().'.html.twig';
    	$fh = fopen($myFile, 'w') or die("Error writing template");
    	fwrite($fh, $design->getUsertemplate());
    	fclose($fh);
    }
}