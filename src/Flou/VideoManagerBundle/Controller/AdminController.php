<?php

namespace Flou\VideoManagerBundle\Controller;

use Flou\VideoManagerBundle\Form\Type\AdminCommentType;

use Flou\VideoManagerBundle\FlouVideoManagerBundle;
use Flou\VideoManagerBundle\Entity\AdminComment;

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
    	$galleries = $em->getRepository('FlouVideoManagerBundle:Gallery')->findAll();
    	
    	//$iter = 0;
    	$needle = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9");
    	$galid = $this->getRequest()->get('galid');
    	
    	//foreach($galleries as $gallery)
    	//{
    		$messages[] = 'gallery: '.$galid;
    		
    		$query = $em
    		->createQuery('
    				SELECT p
    				FROM FlouVideoManagerBundle:Photo p
    				JOIN p.gallery g
    				JOIN p.title t
    				WHERE g.id = :id
    				ORDER BY t.title_de ASC'
    		)->setParameter('id', $galid);
    		$photos = $query->getResult();
    		
    		$iter = 0;
    		foreach($photos as $photo){
    			$iter += 10;
    			$messages[] = '--'.$photo->getTitle()->getTitleDe();
    			$title = $photo->getTitle()->getTitleDe();
    			//$title = 'MUNICH INTERNATIONAL BUSINESS SCHOOL';
    			//$title = \substr($title, 0, -4);
    			$title = \str_replace($needle, "", $title);
    			//$title->setTitleDe(\str_replace($needle, "", $title->getTitleDe()));
    			if($title[0] == '_'){
    				$title = \substr($title, 1);
    			}
    			if($title[strlen($title)-1] == '_'){
    				$title = \substr($title, 0, strlen($title)-1);
    			}
    			$title = \str_replace("_", " ", $title);
    			$title = 'MUNICH FABRIC START';
    			$messages[] = '-->'.$title;
    			$photo->getTitle()->setTitleDe($title);
    			$photo->setOrderrank($iter);
    			//$em->persist($photo);
    		}
    		$em->flush();
    		
    	//}
    	
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
    
    public function commentAction(Request $request)
    {
    	// get em
    	$em = $this->getDoctrine()->getEntityManager();
    	
    	// get user
    	$user =  $em->getRepository('FlouVideoManagerBundle:User')->findOneById($this->get('security.context')->getToken()->getUser()->getId());
    	$channel = $user->getChannel();
    	
    	$adminmessage = new AdminComment();
    	$form = $this->createForm(new AdminCommentType(), $adminmessage);
    	
    	if ($request->getMethod() == 'POST') {
    		$form->bindRequest($request);
    	
    		if ($form->isValid()) {
    			
    			$myFile = $this->get('kernel')->getRootDir().'/logs/admin.log';
    			$fh = fopen($myFile, 'a');
    			fwrite($fh, date(DATE_RFC822)."\t".$adminmessage->getName().": ".$adminmessage->getMessage()."\n");
    			fclose($fh);
    			
    			return $this->redirect($this->generateUrl('admin_getuser'));
    		}
    	}
   
 		return $this->render('FlouVideoManagerBundle:Admin:comment.html.twig', array(
 				'form' => $form->createView(),
 		));
    	
    }
    
    public function createuserAction(){
    }
}