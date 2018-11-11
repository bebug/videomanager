<?php

namespace Flou\VideoManagerBundle\Controller;

use Flou\VideoManagerBundle\Entity\Description;
use Flou\VideoManagerBundle\Entity\Title;
use Flou\VideoManagerBundle\Entity\ZipFile;

use Flou\VideoManagerBundle\Entity\Photo;

use Flou\VideoManagerBundle\FlouVideoManagerBundle;
use Flou\VideoManagerBundle\Entity\Gallery;
use Flou\VideoManagerBundle\Entity\Image;
use Flou\VideoManagerBundle\Entity\PhotoUpload;
use Flou\VideoManagerBundle\Form\Type\GalleryType;
use Flou\VideoManagerBundle\Form\Type\ImageUploadType;
use Flou\VideoManagerBundle\Form\Type\PhotoUploadType;
use Flou\VideoManagerBundle\Form\Type\ZipFileType;
use Flou\VideoManagerBundle\Form\Type\PhotoType;

use Symfony\Component\Finder\Finder;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class GalleryController extends Controller
{
	public function newAction(Request $request)
	{
		$gallery = new Gallery();
		$form = $this->createForm(new GalleryType(), $gallery);
		$em = $this->getDoctrine()->getEntityManager();
		$user = $em->getRepository('FlouVideoManagerBundle:User')->findOneById($this->get('security.context')->getToken()->getUser()->getId());
		
		if ($request->getMethod() == 'POST') {
			$form->bindRequest($request);
		
			if ($form->isValid()) {
		
				$channel = $user->getChannel();
				$channel->addGallerie($gallery);
				$gallery->setChannel($channel);
		
				$em->persist($channel);
				$em->persist($gallery);
				$em->persist($gallery->getTitle());
				
				$em->flush();
		
				//create folder
				$playlistdir = $this->container->getParameter('upload.dir.absolute').'/galleries/'.$channel->getId();
				if(is_dir(realpath($playlistdir)) == false)
				{
					mkdir(($playlistdir));
				}
		
				$sourcedir = realpath($this->container->getParameter('upload.dir.absolute').'/../bundles/flouvideomanager/images');
		
				copy($sourcedir.'/pltemplate_big.jpg', $playlistdir.'/'.$gallery->getId().'_big.jpg');
				copy($sourcedir.'/pltemplate_tiny.jpg', $playlistdir.'/'.$gallery->getId().'_tiny.jpg');
		
				return $this->redirect($this->generateUrl('gallery_list'));
			}
		}
		
		return $this->render('FlouVideoManagerBundle:Gallery:new.html.twig', array(
				'form' => $form->createView(),
		));
	}
	
	public function editAction(Request $request, $galleryid)
	{
		// get em
		$em = $this->getDoctrine()->getEntityManager();
		$user = $this->get('security.context')->getToken()->getUser();
		$gallery = $em->getRepository('FlouVideoManagerBundle:Gallery')->findOneById($galleryid);
			
		if($gallery == null || $gallery->getChannel() !== $user->getChannel())
		{
			return $this->createNotFoundException("Not found");
		}
		else
		{
			$form = $this->createForm(new GalleryType(), $gallery);
	
			if ($request->getMethod() == 'POST') {
				$form->bindRequest($request);
	
				if ($form->isValid()) {
	
					$em->flush();
	
					return $this->redirect($this->generateUrl('gallery_list'));
				}
			}
	
			return $this->render('FlouVideoManagerBundle:Gallery:new.html.twig', array(
					'form' => $form->createView(),
			));
		}
	}
	
	public function photolistAction($galleryid)
	{
		$em = $this->getDoctrine()->getEntityManager();
		$user = $this->get('security.context')->getToken()->getUser();
		$gallery = $em->getRepository('FlouVideoManagerBundle:Gallery')->findOneById($galleryid);
		
		if($gallery == null || $gallery->getChannel() !== $user->getChannel())
		{
			return $this->createNotFoundException("Not found");
		}
		else
		{
			$query = $em
			->createQuery('
					SELECT p
					FROM FlouVideoManagerBundle:Photo p
					JOIN p.gallery g
					WHERE g.id = :id
					ORDER BY p.orderrank ASC'
			)->setParameter('id', $gallery->getId());
			$photos = $query->getResult();
			
			return $this->render('FlouVideoManagerBundle:Gallery:photolist.html.twig', array( 'photos' => $photos, 'channel' => $user->getChannel(), 'gallery' => $gallery
			));
		}
	}
	
	public function deletephotoAction($galleryid, $photoid){
		$em = $this->getDoctrine()->getEntityManager();
		$user = $this->get('security.context')->getToken()->getUser();
		$photo = $em->getRepository('FlouVideoManagerBundle:Photo')->findOneById($photoid);
		$gallery = $photo->getGallery();
		
		if($photo == null || $photo->getGallery()->getChannel() !== $user->getChannel())
		{
			return $this->createNotFoundException("Not found");
		}
		else
		{
			//delete files
			$imagedir = $this->container->getParameter('upload.dir.absolute').'/galleries/'.$user->getChannel()->getId().'/'.$galleryid;
			
			if(file_exists($imagedir.'/'.$photo->getId().'_tiny.jpg'))
			{
				unlink($imagedir.'/'.$photo->getId().'_tiny.jpg');
			}
			if(file_exists($imagedir.'/'.$photo->getId().'_big.jpg'))
			{
				unlink($imagedir.'/'.$photo->getId().'_big.jpg');
			}
			if(file_exists($imagedir.'/'.$photo->getId().'.jpg'))
			{
				unlink($imagedir.'/'.$photo->getId().'.jpg');
			}		
			
			$gallery->removePhoto($photo);
			$em->remove($photo->getTitle());
			$em->remove($photo->getDescription());
			$em->remove($photo);
			$em->flush();
			
			return $this->photolistAction($galleryid);
		}
		
	}
	
	public function editphotoAction(Request $request, $galleryid, $photoid)
	{
		// get em
		$em = $this->getDoctrine()->getEntityManager();
		$user = $this->get('security.context')->getToken()->getUser();
		$photo = $em->getRepository('FlouVideoManagerBundle:Photo')->findOneById($photoid);
			
		if($photo == null || $photo->getGallery()->getChannel() !== $user->getChannel())
		{
			return $this->createNotFoundException("Not found");
		}
		else
		{
			$form = $this->createForm(new PhotoType(), $photo);
	
			if ($request->getMethod() == 'POST') {
				$form->bindRequest($request);
	
				if ($form->isValid()) {
	
					$em->flush();
	
					return $this->photolistAction($galleryid);
				}
			}
	
			return $this->render('FlouVideoManagerBundle:Gallery:editphoto.html.twig', array(
					'form' => $form->createView(), 'galleryid'=> $galleryid, 'photoid'=> $photoid, 'channelid' => $user->getChannel()->getId(),
			));
		}
	}
	
	public function newZipFileAction(Request $request, $galleryid)
	{
		$em = $this->getDoctrine()->getEntityManager();
		$user = $this->get('security.context')->getToken()->getUser();
		$gallery = $em->getRepository('FlouVideoManagerBundle:Gallery')->findOneById($galleryid);
		
		$zipFile = new ZipFile();
		$form = $this->createForm(new ZipFileType(), $zipFile);
		
		if($gallery == null || $gallery->getChannel() !== $user->getChannel())
		{
			return $this->createNotFoundException("Not found");
		}
		else
		{
			if ($request->getMethod() == 'POST') {
				$form->bindRequest($request);
					
				if ($form->isValid()) {

					$zipfilename = $user->getId().'.'.$zipFile->file->guessExtension();
					$zipFile->file->move($this->container->getParameter('upload.dir.absolute').'/temp/', $zipfilename);
					
					// unpack zip
					@set_time_limit(120);
					$zipdir = $this->container->getParameter('upload.dir.absolute').'/temp/zip'.$galleryid;
					if(is_dir(realpath($zipdir)) == false)
					{
						mkdir($zipdir);
					}
					
					$zipArchive = new \ZipArchive();
					$res = $zipArchive->open($this->container->getParameter('upload.dir.absolute').'/temp/'.$zipfilename);
					if ($res === TRUE) {
						$zipArchive->extractTo($zipdir);
						$zipArchive->close();
					}
					@set_time_limit();
					
					// import images
					$finder = new Finder();
					$finder->files()->in($zipdir);
					foreach ($finder as $file) {
						
						if($file->getExtension() == 'jpg' ||
								$file->getExtension() == 'jpeg' ||
								$file->getExtension() == 'png' ||
								$file->getExtension() == 'gif')
						{
							$photo = new Photo();
							$photo->setDescription(new Description());
							$photo->setTitle(new Title());
							$photo->getTitle()->setTitleDe(basename($file->getBasename('.'.$file->getExtension())));
							$photo->getTitle()->setTitleEn(basename($file->getBasename('.'.$file->getExtension())));
							$photo->getTitle()->setTitleFr(basename($file->getBasename('.'.$file->getExtension())));
							$photo->setGallery($gallery);
							$photo->setOrderrank(0);
							$gallery->addPhoto($photo);
							
							$em->persist($photo);
							$em->persist($photo->getTitle());
							$em->persist($photo->getDescription());
							$em->persist($gallery);
							
							$em->flush();
							
							if(!$this->safeImage($file, $gallery->getId(), $photo->getId(), $user->getChannel()->getId(), $user->getId()))
							{
								$this->deletephotoAction($gallery->getId(), $photo->getId());
							}
						}
					}
					
					//delete temp rar
					unlink($this->container->getParameter('upload.dir.absolute').'/temp/'.$zipfilename);
					HelperController::rrmdir($zipdir);
					
					return $this->photolistAction($galleryid);
				}
			}

			return $this->render('FlouVideoManagerBundle:Gallery:newzipfile.html.twig', array( 'form' => $form->createView(),
			));
		}
	}
	
	public function newphotoAction(Request $request, $galleryid)
	{
		$em = $this->getDoctrine()->getEntityManager();
		$user = $this->get('security.context')->getToken()->getUser();
		$gallery = $em->getRepository('FlouVideoManagerBundle:Gallery')->findOneById($galleryid);
		
		$photoupload = new PhotoUpload();
		$photoupload->orderrank = 0;
		$form = $this->createForm(new PhotoUploadType(), $photoupload);
		
		if($gallery == null || $gallery->getChannel() !== $user->getChannel())
		{
			return $this->createNotFoundException("Not found");
		}
		else
		{
			if ($request->getMethod() == 'POST') {
				$form->bindRequest($request);
			
				if ($form->isValid()) {
					
					$photo = new Photo();
					$photo->setDescription($photoupload->description);
					$photo->setOrderrank($photoupload->orderrank);
					$photo->setTitle($photoupload->title);
					$photo->setGallery($gallery);
					$gallery->addPhoto($photo);
					
					$em->persist($photo);
					$em->persist($photo->getTitle());
					$em->persist($photo->getDescription());
					$em->persist($gallery);
					$em->flush();
					
					if(!$this->safeImage($photoupload->file, $gallery->getId(), $photo->getId(), $user->getChannel()->getId(), $user->getId()))
					{
						return $this->deletephotoAction($gallery->getId(), $photo->getId());
					}
					
					
					return $this->photolistAction($galleryid);
					
				}
			}
			
			HelperController::initTinymce($this->container->getParameter('upload.dir.mce').'/files/'.$user->getId(), $this->container->getParameter('upload.dir.absolute').'/files/'.$user->getId(),$this->get("session"));
			
			return $this->render('FlouVideoManagerBundle:Gallery:newphoto.html.twig', array( 'form' => $form->createView(),
			));
		}
	}
	
	private function safeImage($file, $galleryid, $photoid, $channelid, $userid){
		
		$returnvalue = false;
		
		//safe temporaly
		if(@get_class($file) == 'Symfony\Component\HttpFoundation\File\UploadedFile'){
			$tempextension = $file->guessExtension();
			$tempname = $photoid.'.'.$tempextension;
			$file->move($this->container->getParameter('upload.dir.absolute').'/temp/', $tempname);
		}
		elseif(@get_class($file) == 'Symfony\Component\Finder\SplFileInfo'){ // from zip upload
			$tempextension = $file->getExtension();
			$tempname = 'zip'.$galleryid.'/'.$file->getFilename();
		}
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
		
			//resize 1280*720
			if($imageratio > 16/9){
				$tempsrcx = @min(1280, imagesx($tempimage));
				$tempsrcy = floor($tempsrcx / $imageratio);
				
				$tempsrcxbig = 512;
				$tempsrcybig = floor($tempsrcxbig / $imageratio);
				
				$tempsrcxsmal = 256;
				$tempsrcysmal = floor($tempsrcxsmal / $imageratio);
			}else{
				$tempsrcy = @min(720, imagesy($tempimage));
				$tempsrcx = floor($tempsrcy * $imageratio);
				
				$tempsrcybig = 288;
				$tempsrcxbig = floor($tempsrcybig * $imageratio);
				
				$tempsrcysmal = 144;
				$tempsrcxsmal = floor($tempsrcysmal * $imageratio);
			}
			
			$newsmalimg = @imagecreatetruecolor($tempsrcxsmal, $tempsrcysmal);
			$newbigimg = @imagecreatetruecolor($tempsrcxbig, $tempsrcybig);
			$newimg = @imagecreatetruecolor($tempsrcx, $tempsrcy);
			
			@imagecopyresampled($newsmalimg, $tempimage, 0, 0, 0, 0, $tempsrcxsmal, $tempsrcysmal, imagesx($tempimage), imagesy($tempimage));
			@imagecopyresampled($newbigimg, $tempimage, 0, 0, 0, 0, $tempsrcxbig, $tempsrcybig, imagesx($tempimage), imagesy($tempimage));
			@imagecopyresampled($newimg, $tempimage, 0, 0, 0, 0, $tempsrcx, $tempsrcy, imagesx($tempimage), imagesy($tempimage));
			
			$imagedir = $this->container->getParameter('upload.dir.absolute').'/galleries/'.$channelid.'/'.$galleryid.'/';
			
			if(is_dir(realpath($imagedir)) == false)
			{
				mkdir(($imagedir));
			}
			
			@imagejpeg($newsmalimg, $imagedir.$photoid.'_tiny.jpg', 75);
			@imagejpeg($newbigimg, $imagedir.$photoid.'_big.jpg', 75);
			@imagejpeg($newimg, $imagedir.$photoid.'.jpg', 75);
		
			$returnvalue = true;
		}
			
		// File löschen
		if(file_exists($this->container->getParameter('upload.dir.absolute').'/temp/'.$tempname))
		{
		unlink($this->container->getParameter('upload.dir.absolute').'/temp/'.$tempname);
		}
		
		return $returnvalue;
	}
	
	public function listAction()
	{
		$em = $this->getDoctrine()->getEntityManager();
		$user = $this->get('security.context')->getToken()->getUser();
	
		$galleries = $user->getChannel()->getGalleries();
			
		return $this->render('FlouVideoManagerBundle:Gallery:list.html.twig', array( 'galleries' => $galleries
		));
	}
	
	public function deleteAction($galleryid)
	{
		$em = $this->getDoctrine()->getEntityManager();
		$user = $this->get('security.context')->getToken()->getUser();
	
		$gallery = $em->getRepository('FlouVideoManagerBundle:Gallery')->findOneById($galleryid);
	
		if($gallery == null || $gallery->getChannel() !== $user->getChannel())
		{
			return $this->createNotFoundException("Not found");
		}
		else
		{
			foreach($gallery->getPhotos() as $photo){
				$em->remove($photo->getTitle());
				$em->remove($photo->getDescription());
				$em->remove($photo);
			}
			
			$em->remove($gallery);
			$em->remove($gallery->getTitle());
			$em->flush();
				
			$playlistdir = $this->container->getParameter('upload.dir.absolute').'/galleries/'.$user->getChannel()->getId();
			// delete all photos
			HelperController::rrmdir($playlistdir.'/'.$galleryid);
			// delete thumb
			if(file_exists($playlistdir.'/'.$galleryid.'_tiny.jpg'))
			{
				unlink($playlistdir.'/'.$galleryid.'_tiny.jpg');
			}
			if(file_exists($playlistdir.'/'.$galleryid.'_big.jpg'))
			{
				unlink($playlistdir.'/'.$galleryid.'_big.jpg');
			}
		}
	
	
		return $this->listAction();
	}
	
	public function pictureAction(Request $request, $galleryid){
	
		$em = $this->getDoctrine()->getEntityManager();
		$user = $this->get('security.context')->getToken()->getUser();
		$gallery = $em->getRepository('FlouVideoManagerBundle:Gallery')->findOneById($galleryid);
		$image = new Image();
	
		if($gallery == null || $gallery->getChannel() !== $user->getChannel())
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
	
						// cut 16/5 ratio
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
	
						$imagedir = $this->container->getParameter('upload.dir.absolute').'/galleries/'.$user->getChannel()->getId().'/';
	
						
						
						@imagejpeg($newsmalimg, $imagedir.$gallery->getId().'_tiny.jpg', 75);
						@imagejpeg($newbigimg, $imagedir.$gallery->getId().'_big.jpg', 75);
	
	
					}
						
					// File löschen
					unlink($this->container->getParameter('upload.dir.absolute').'/temp/'.$tempname);
				}
			}
	
			return $this->render('FlouVideoManagerBundle:gallery:picture.html.twig', array(
					'form' => $form->createView(), 'galleryid' => $gallery->getId(), 'channelid' => $user->getChannel()->getId(),
			));
		}
	}
}