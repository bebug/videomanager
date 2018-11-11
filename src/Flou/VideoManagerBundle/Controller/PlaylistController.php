<?php

namespace Flou\VideoManagerBundle\Controller;

use Flou\VideoManagerBundle\Form\Type\VideolistType;

use Flou\VideoManagerBundle\FlouVideoManagerBundle;
use Flou\VideoManagerBundle\Entity\Playlist;
use Flou\VideoManagerBundle\Form\Type\PlaylistType;
use Flou\VideoManagerBundle\Entity\Image;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Flou\VideoManagerBundle\Form\Type\ImageUploadType;

use Doctrine\ORM\EntityRepository;

class PlaylistController extends Controller{
	
	public function pictureAction(Request $request, $playlistid){
	
		$em = $this->getDoctrine()->getEntityManager();
		$user = $this->get('security.context')->getToken()->getUser();
		$playlist = $em->getRepository('FlouVideoManagerBundle:Playlist')->findOneById($playlistid);
		$image = new Image();
	
		if($playlist == null || $playlist->getChannel() !== $user->getChannel())
		{
			return $this->createNotFoundException("Not found");
		}
		else{
			$form = $this->createForm(new ImageUploadType(), $image);
				
			if ($request->getMethod() == 'POST') {
				$form->bindRequest($request);
					
				if ($form->isValid()) {
	
					//safe temporaly
					$tempextension = $image->file->guessExtension();
					$tempname = $user->getId().'.'.$tempextension;
					$image->file->move($this->container->getParameter('upload.dir.absolute').'/temp/', $tempname);
					//open temp image
					if($tempextension == 'jpg' || $tempextension == 'jpeg')
					{
						$tempimage = @imagecreatefromjpeg($this->container->getParameter('upload.dir.absolute').'/temp/'.$tempname);
					}
					elseif($tempextension == 'png')
					{
						$tempimage = @imagecreatefrompng($this->container->getParameter('upload.dir.absolute').'/temp/'.$tempname);
					}
					elseif($tempextension == 'gif')
					{
						$tempimage = @imagecreatefromgif($this->container->getParameter('upload.dir.absolute').'/temp/'.$tempname);
					}
						
					if($tempimage)
					{
						$imageratio = imagesx($tempimage)/imagesy($tempimage);
	
						// cut 19/5 ratio
						if($imageratio > 16/5){
							$tempsrcy = imagesy($tempimage);
							$tempsrcx = floor($tempsrcy * 16/5);
						}
						else{
							$tempsrcx = imagesx($tempimage);
							$tempsrcy = floor($tempsrcx * 5/16);
						}
	
						$newsmalimg = @imagecreatetruecolor(208, 65);
						$newbigimg = @imagecreatetruecolor(640,200);
						
						$startx = abs(floor(($tempsrcx-imagesx($tempimage))/2));
						$starty = abs(floor(($tempsrcy-imagesy($tempimage))/2));
						
						@imagecopyresampled($newsmalimg, $tempimage, 0, 0, $startx, $starty, 208, 65, $tempsrcx, $tempsrcy);
						@imagecopyresampled($newbigimg, $tempimage, 0, 0, $startx, $starty, 640, 200, $tempsrcx, $tempsrcy);
	
						$imagedir = $this->container->getParameter('upload.dir.absolute').'/playlists/'.$user->getChannel()->getId().'/';
						
						@imagejpeg($newsmalimg, $imagedir.$playlist->getId().'_tiny.jpg', 75);
						@imagejpeg($newbigimg, $imagedir.$playlist->getId().'_big.jpg', 75);
	
						
					}
					
					// File löschen
					unlink($this->container->getParameter('upload.dir.absolute').'/temp/'.$tempname);
				}
			}
				
			return $this->render('FlouVideoManagerBundle:Playlist:picture.html.twig', array(
					'form' => $form->createView(), 'playlistid' => $playlist->getId(), 'channelid' => $user->getChannel()->getId(),
			));
		}
	}
	
	public function newAction(Request $request)
	{
		$playlist = new Playlist();
		$form = $this->createForm(new PlaylistType(), $playlist);
		$em = $this->getDoctrine()->getEntityManager();
		$user = $em->getRepository('FlouVideoManagerBundle:User')->findOneById($this->get('security.context')->getToken()->getUser()->getId());
		
		if ($request->getMethod() == 'POST') {
			$form->bindRequest($request);
		
			if ($form->isValid()) {
				
				$channel = $user->getChannel();
				$channel->addPlaylist($playlist);
				
				$em->persist($channel);
				$em->persist($playlist);
				$em->persist($playlist->getTitle());
				$em->flush();
				
				//create folder
				$playlistdir = $this->container->getParameter('upload.dir.absolute').'/playlists/'.$channel->getId();
				echo $playlistdir;
				if(is_dir(realpath($playlistdir)) == false)
				{
					mkdir(($playlistdir));
				}
				
				$sourcedir = realpath($this->container->getParameter('upload.dir.absolute').'/../bundles/flouvideomanager/images');

				copy($sourcedir.'/pltemplate_big.jpg', $playlistdir.'/'.$playlist->getId().'_big.jpg');
				copy($sourcedir.'/pltemplate_tiny.jpg', $playlistdir.'/'.$playlist->getId().'_tiny.jpg');

				return $this->redirect($this->generateUrl('playlist_list'));
			}
		}
		
		return $this->render('FlouVideoManagerBundle:Playlist:new.html.twig', array(
				'form' => $form->createView(),
		));
	}
	
	public function embedAction()
	{
		$data['playlist'] = $this->getRequest()->get('playlist');
	
		return $this->render('FlouVideoManagerBundle:Playlist:embed.html.twig', $data
		);
	}
	
	public function editAction(Request $request, $playlistid)
	{
		// get em
		$em = $this->getDoctrine()->getEntityManager();
		$user = $this->get('security.context')->getToken()->getUser();
		$playlist = $em->getRepository('FlouVideoManagerBundle:Playlist')->findOneById($playlistid);
		 
		if($playlist == null || $playlist->getChannel() !== $user->getChannel())
		{
			return $this->createNotFoundException("Not found");
		}
		else
		{
			$form = $this->createForm(new PlaylistType(), $playlist);
			 
			if ($request->getMethod() == 'POST') {
				$form->bindRequest($request);
	
				if ($form->isValid()) {
	
					$em->flush();
	
					return $this->redirect($this->generateUrl('playlist_list'));
				}
			}
			 
			return $this->render('FlouVideoManagerBundle:Playlist:edit.html.twig', array(
					'form' => $form->createView(),
			));
		}
	}
	
	public function listAction()
	{
		$em = $this->getDoctrine()->getEntityManager();
		$user = $this->get('security.context')->getToken()->getUser();
		
		$playlists = $user->getChannel()->getPlaylists();
		 
		return $this->render('FlouVideoManagerBundle:Playlist:list.html.twig', array( 'playlists' => $playlists
		));
	}
	
	public function videolistAction(Request $request, $playlistid)
	{
		$em = $this->getDoctrine()->getEntityManager();
		$user = $this->get('security.context')->getToken()->getUser();
		$channel = $user->getChannel();
		
		$playlist = $em->getRepository('FlouVideoManagerBundle:Playlist')->findOneById($playlistid);
		
		//$form = $this->createForm(new VideolistType($channel->getId()));
		
		$channel_id = $channel->getId();
		
		$form = $this->createFormBuilder()
			->add('video', 'entity', array(
				'label'     => 'Video',
				'empty_value' => false,
				'required'  => true,
				'class'		=> 'FlouVideoManagerBundle:Video',
				'query_builder' => function(EntityRepository $er) use ($channel_id) {
					return $er->createQueryBuilder('u')
						->select('u')
						->leftJoin('u.channel', 'c')
						->where('c.id = '.$channel_id);
			},))
			->getForm();
		
		if($playlist == null || $playlist->getChannel() !== $channel)
		{
			return $this->createNotFoundException("Not found");
		}
		else{
			if ($request->getMethod() == 'POST') {
	    		$form->bindRequest($request);
	    	
	    		if ($form->isValid()) {
	    			$data = $form->getData();
	    			$video = $data['video'];
	    			$videos = $playlist->getVideos();
	    			
	    			//print_r($videos);
	    			
	    			if($videos->contains($video))
	    			{
	    				$this->get('session')->setFlash('notice', 'Video '.$video->getTitle()->getTitleDe().' ist bereits in der Playlist vorhanden!');
	    			}else{
	    				$playlist->addVideo($video);
	    				$em->persist($playlist);
	    				$em->persist($video);
	    				$em->flush();
	    			}
	    		}
	    	}
		}
		
		return $this->render('FlouVideoManagerBundle:Playlist:videolist.html.twig', array( 'playlist' => $playlist, 'form' => $form->createView()
		));
	}
	
	public function videodeleteAction($videoid, $playlistid)
	{
		$em = $this->getDoctrine()->getEntityManager();
		$user = $this->get('security.context')->getToken()->getUser();
		
		$playlist = $em->getRepository('FlouVideoManagerBundle:Playlist')->findOneById($playlistid);
		$video = $em->getRepository('FlouVideoManagerBundle:Video')->findOneById($videoid);
		
		if($playlist == null || $video == null || $playlist->getChannel() !== $user->getChannel())
		{
			return $this->createNotFoundException("Not found");
		}
		else
		{
			if($playlist->getVideos()->contains($video))
			{
				$playlist->getVideos()->remove($playlist->getVideos()->indexOf($video));
				$em->persist($playlist);
				$em->persist($video);
				$em->flush();
			}
		}
		
		return $this->videolistAction(new Request(), $playlistid);
	}
	
	public function deleteAction($playlistid)
	{
		$em = $this->getDoctrine()->getEntityManager();
		$user = $this->get('security.context')->getToken()->getUser();
		
		$playlist = $em->getRepository('FlouVideoManagerBundle:Playlist')->findOneById($playlistid);
		
		if($playlist == null || $playlist->getChannel() !== $user->getChannel())
		{
			return $this->createNotFoundException("Not found");
		}
		else
		{
			$em->remove($playlist);
			$em->remove($playlist->getTitle());
			$em->flush();
			
			$playlistdir = $this->container->getParameter('upload.dir.absolute').'/playlists/'.$user->getChannel()->getId();
			if(file_exists($playlistdir.'/'.$playlist->getId().'_tiny.jpg'))
			{
				unlink($playlistdir.'/'.$playlist->getId().'_tiny.jpg');
			}
			if(file_exists($playlistdir.'/'.$playlist->getId().'_big.jpg'))
			{
				unlink($playlistdir.'/'.$playlist->getId().'_big.jpg');
			}
		}
		
		
		return $this->listAction($playlistid);
	}
}