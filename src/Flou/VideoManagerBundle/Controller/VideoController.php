<?php 

namespace Flou\VideoManagerBundle\Controller;

use Flou\VideoManagerBundle\Entity\Youtubelink;

use Flou\VideoManagerBundle\FlouVideoManagerBundle;
use Flou\VideoManagerBundle\Entity\Video;
use Flou\VideoManagerBundle\Entity\Title;
use Flou\VideoManagerBundle\Entity\Image;
use Flou\VideoManagerBundle\Entity\S3;
use Flou\VideoManagerBundle\Entity\Description;
use Flou\VideoManagerBundle\Form\Type\VideoType;
use Flou\VideoManagerBundle\Form\Type\VideoUploadType;
use Flou\VideoManagerBundle\Form\Type\YoutubelinkType;
use Flou\VideoManagerBundle\Form\Type\ImageUploadType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;


/**
 * @Template()
 */
class VideoController extends Controller
{	
	public function pictureAction(Request $request, $videoid){
		
		$em = $this->getDoctrine()->getEntityManager();
		$user = $this->get('security.context')->getToken()->getUser();
		$video = $em->getRepository('FlouVideoManagerBundle:Video')->findOneById($videoid);
		$image = new Image();
		
		if($video == null || $video->getChannel() !== $user->getChannel())
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
					if($tempextension == 'jpg')
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

						// cut 19/9 ratio
						if($imageratio > 16/9){
							$tempsrcy = imagesy($tempimage);
							$tempsrcx = floor($tempsrcy * 16/9);
						}
						else{
							$tempsrcx = imagesx($tempimage);
							$tempsrcy = floor($tempsrcx * 9/16);
						}
						
						$newsmalimg = @imagecreatetruecolor(160,90);
						$newbigimg = @imagecreatetruecolor(640,360);
						
						$startx = abs(floor(($tempsrcx-imagesx($tempimage))/2));
						$starty = abs(floor(($tempsrcy-imagesy($tempimage))/2));
						
						@imagecopyresampled($newsmalimg, $tempimage, 0, 0, $startx, $starty, 160, 90, $tempsrcx, $tempsrcy);
						@imagecopyresampled($newbigimg, $tempimage, 0, 0, $startx, $starty, 640, 360, $tempsrcx, $tempsrcy);
						
						@imagejpeg($newsmalimg, $video->getLocation().'/../'.$video->getId().'_tiny.jpg', 75);
						@imagejpeg($newbigimg, $video->getLocation().'/../'.$video->getId().'_big.jpg', 95);
						
					}
					
					unlink($this->container->getParameter('upload.dir.absolute').'/temp/'.$tempname);
				}
			}
			
			return $this->render('FlouVideoManagerBundle:Video:picture.html.twig', array(
					'form' => $form->createView(), 'videoid' => $videoid, 'channelid' => $video->getChannel()->getId(),
			));
		}
	}
	
	public function listAction()
	{
		$channel = $this->get('security.context')->getToken()->getUser()->getChannel();
		$videos = $channel->getVideos();
		
		return $this->render('FlouVideoManagerBundle:Video:list.html.twig', array(
    			'videos' => $videos, 'channel' => $channel,
    	));
	}
	
	public function embedAction()
	{
		$data['video'] = $this->getRequest()->get('video');
		
		return $this->render('FlouVideoManagerBundle:Video:embed.html.twig', $data
		);
	}
	
	public function editAction(Request $request, $videoid)
    {
    	// get em
    	$em = $this->getDoctrine()->getEntityManager();
    	$user = $this->get('security.context')->getToken()->getUser();
    	$video = $em->getRepository('FlouVideoManagerBundle:Video')->findOneById($videoid);
    	
    	if($video == null || $video->getChannel() !== $user->getChannel())
    	{
    		return $this->createNotFoundException("Not found");
    	}
    	else
    	{
    	
	    	$form = $this->createForm(new VideoType(), $video);
	    	
	    	if ($request->getMethod() == 'POST') {
	    		$form->bindRequest($request);
	    		
	    		if ($form->isValid()) {
	    			 
	    			$em->flush();
	    		
	    			return $this->redirect($this->generateUrl('video_list'));
	    		}
	    	}
	    	
	    	HelperController::initTinymce($this->container->getParameter('upload.dir.mce').'/files/'.$user->getId(), $this->container->getParameter('upload.dir.absolute').'/files/'.$user->getId(),$this->get("session"));
	    	
	    	return $this->render('FlouVideoManagerBundle:Video:edit.html.twig', array(
	    			'form' => $form->createView(),
	    	));
    	}
    }
	
	public function deleteAction($videoid)
	{
		// get em
		$em = $this->getDoctrine()->getEntityManager();
		$user = $this->get('security.context')->getToken()->getUser();
		
		$video = $em->getRepository('FlouVideoManagerBundle:Video')->findOneById($videoid);
		
		if($video == null || $video->getChannel() !== $user->getChannel())
		{
			return $this->createNotFoundException("Not found");
		}else{
			if($video->getS3Bucket()) // delete s3
			{
				S3::setAuth($this->container->getParameter('s3.public.key'), $this->container->getParameter('s3.private.key'));
				
				if(S3::deleteObject($video->getS3bucket(), $video->getS3key()))
				{
					S3::deleteObject($video->getS3bucket(), substr($video->getS3key(), 0, 9));
				}
			}
			
			if(file_exists($video->getLocation())){
				$dir = opendir($video->getLocation());
				// Verzeichnisinhalt auslesen
				while ($file = readdir ($dir))
				{
					// "." und ".." bei der Ausgabe unterdrücken
					if($file != "." && $file != "..")
					{
						// File löschen
						unlink($video->getLocation().'/'.$file);
					}
				}
				// Verzeichnis schließen
				closedir($dir);
			}
			
			if(file_exists($video->getLocation().'/../'.$video->getId().'_big.jpg'))
			{
				unlink($video->getLocation().'/../'.$video->getId().'_big.jpg');
			}
			
			if(file_exists($video->getLocation().'/../'.$video->getId().'_tiny.jpg'))
			{
				unlink($video->getLocation().'/../'.$video->getId().'_tiny.jpg');
			}
			
			if(is_dir(realpath($video->getLocation()))){
				rmdir($video->getLocation());
			}
			
			$em->remove($video->getTitle());
			$em->remove($video->getDescription());
			$em->remove($video->getShortdescription());
			$em->remove($video);
			$em->flush();
		}
		return $this->redirect($this->generateUrl('video_list'));
	}
	
	public function serveruploadAction()
	{
		// get em
		$em = $this->getDoctrine()->getEntityManager();
		
		$noflash = $this->getRequest()->get('noflash');
		
		// For flash upload
		/*if (isset($_POST["PHPSESSID"])) {
			echo 'Session found';
		    session_write_close();             // End the previously-started session
		    session_id($_POST["PHPSESSID"]);   // Set the new session ID
		    session_start();                   // Start it
		    $noflash = false;
		}*/
		
		// get user
		$user =  $em->getRepository('FlouVideoManagerBundle:User')->findOneById($this->get('security.context')->getToken()->getUser()->getId());
		$channel = $user->getChannel();
		
		$uploadinfo['s3params'] = array();
		$s3upload = false;
		
		$video = new Video();
		$form = $this->createForm(new VideoUploadType(), $video);
		
		if($channel->getS3bucket()) // S3 Upload
		{
			$returnpath;
			$s3upload = true;
			if(!$noflash) // flash
			{
				$returnpath = '201';
			}else {
				$returnpath = 'http://'.$_SERVER['SERVER_NAME'].$this->generateUrl('video_s3return');
			}
			
			$uploadinfo['returnafters3'] = 'http://'.$_SERVER['SERVER_NAME'].$this->generateUrl('video_s3return');
			$uploadinfo['action'] = 'http://' . $channel->getS3bucket() . '.s3.amazonaws.com/';
			$uploadinfo['prefix'] = strval(time());
			$uploadinfo['s3params'] = $this->getS3UploadParam($channel->getS3bucket(), $returnpath, $uploadinfo['prefix'].'/', !$noflash);
			$uploadinfo['bucket'] = $channel->getS3bucket();
		}
		else // host on own server
		{
			$uploadinfo['action'] = '';
			
			if ($this->getRequest()->getMethod() === 'POST') {

				$form->bindRequest($this->getRequest());
				
				var_dump($this->getRequest());
				
				if (!$form->isValid()) {
					$this->get('session')->setFlash('notice', 'Ungültige Datei! Achten Sie auf Format und Größe');
				}
				else 
				{
					$channel->addVideo($video);
					
					$this->safeOnServer($video);
					$video->setTitle(new Title());
					$video->getTitle()->setTitleDe($video->getFilename());
					$video->setDescription(new Description());
					$video->setShortdescription(new Description());
					$this->setDuration($video);
					
					$em->persist($video->getTitle());
					$em->persist($video->getDescription());
					$em->persist($video->getShortdescription());
					$em->persist($video);
					$em->persist($channel);
					$em->flush();
			
					$this->createThumb($channel, $video);
					return $this->redirect($this->generateUrl('video_list'));
				}
			}
		}
		
		if($noflash || $channel->getS3bucket() == "" ){return $this->render('FlouVideoManagerBundle:Video:serverupload.html.twig', array(
					'uploadinfo' => $uploadinfo, 'form' => $form->createView(), 's3upload' => $s3upload,
			));
		}
		else {
			return $this->render('FlouVideoManagerBundle:Video:flashserverupload.html.twig', array(
					'uploadinfo' => $uploadinfo, 's3upload' => $s3upload,
			));
		}
	}
	
	/**
	 * This method gets called after s3 upload
	 */
	public function s3returnAction()
	{
		if ($this->getRequest()->getMethod() === 'GET') {
			
			$bucket = $this->getRequest()->get('bucket');
			$key = $this->getRequest()->get('key');
			
			if($bucket && $key) //valid get
			{
				// valid video file?
				if(preg_match('/\.(mp4|m4v|f4v|webm|flv)$/i', $key))
				{
					// get em
					$em = $this->getDoctrine()->getEntityManager();
					
					// get user
					$user =  $em->getRepository('FlouVideoManagerBundle:User')->findOneById($this->get('security.context')->getToken()->getUser()->getId());
					$channel = $user->getChannel();
					
					$video = new Video();
					$channel->addVideo($video);
					
					$video->sets3key($key);
					$video->setS3bucket($bucket);
					
					if($channel->getStreamdistribution() != "")
					{
						$video->setRtmp($channel->getStreamdistribution());
						$video->setHttp("http://s3-eu-west-1.amazonaws.com/".$video->getS3bucket().'/'.$key);
						//$video->setHttp($channel->getDownloaddistribution().'/'.$key);
					}
					else
					{
						$video->setHttp("http://s3-eu-west-1.amazonaws.com/".$video->getS3bucket().'/'.$key);
					}
					
					$prefix = $channel->getId().'/'.substr($key,0,9);
					$video->setLocation(realpath($this->getUploadRootDir()).'/'.$prefix.'/');
					$video->setFilename(basename($key));
					
					$video->setTitle(new Title());
					$video->getTitle()->setTitleDe(basename($key));
					$video->setShortdescription(new Description());
					$video->setDescription(new Description());
	
					$video->setEnabled(false);
					$video->setUploadtime(new \DateTime("now"));
					$this->setDuration($video);
					
					$em->persist($video->getTitle());
					$em->persist($video->getDescription());
					$em->persist($video->getShortdescription());
					$em->persist($video);
					$em->persist($channel);
					$em->flush();
					
					$this->createThumb($channel, $video);
				}
				else
				{
					S3::setAuth($this->container->getParameter('s3.public.key'), $this->container->getParameter('s3.private.key'));
					
					if(S3::deleteObject($bucket, $key))
					{
						S3::deleteObject($bucket, substr($key, 0, 9));
					}
					$this->get('session')->setFlash('notice', 'Ungültige Datei! Achten Sie auf Format und Größe');
				}
			}
		}
		
		return $this->redirect($this->generateUrl('video_list'));
	}

	public function ytlinkAction(Request $request)
	{
		$ytlink = new Youtubelink();
		$form = $this->createForm(new YoutubelinkType(), $ytlink);
		
		if ($request->getMethod() == 'POST') {
			$form->bindRequest($request);
			
			$datei = @fopen('http://img.youtube.com/vi/'.$ytlink->getLink().'/1.jpg', 'r');
			
			if ($form->isValid() && $datei) {

				// get em
				$em = $this->getDoctrine()->getEntityManager();
					
				// get user
				$user =  $em->getRepository('FlouVideoManagerBundle:User')->findOneById($this->get('security.context')->getToken()->getUser()->getId());
				$channel = $user->getChannel();
					
				$video = new Video();
				$channel->addVideo($video);
				
				$key = strval(time());
				$prefix = $channel->getId().'/'.substr($key,0,9);
				$video->setLocation(($this->getUploadRootDir()).'/'.$prefix.'/');
				
				$video->setHttp('http://www.youtube.com/watch?v='.$ytlink->getLink());
				$video->setTitle(new Title());
				$video->setShortdescription(new Description());
				$video->setDescription(new Description());
				
				$video->setEnabled(false);
				$video->setUploadtime(new \DateTime("now"));
				// duration TODO
				
				////// read feed
				$ytdataurl = "http://gdata.youtube.com/feeds/api/videos/". $ytlink->getLink();
				$feedURL = $ytdataurl;
				$sxml = simplexml_load_file($feedURL);
				$media = $sxml->children('http://search.yahoo.com/mrss/');
				// get <yt:duration> node for video length
				$yt = $media->children('http://gdata.youtube.com/schemas/2007');
				$attrs = $yt->duration->attributes();
				$length = $attrs['seconds'];
				$video->getTitle()->setTitleDe($sxml->title);
				$video->getDescription()->setDescriptionDe($sxml->content);
				$video->getShortdescription()->setDescriptionDe($sxml->content);
				$video->setDuration($this->encodeDuration($length));
				//////
				
				$em->persist($video->getTitle());
				$em->persist($video->getDescription());
				$em->persist($video->getShortdescription());
				$em->persist($video);
				$em->persist($channel);
				$em->flush();
				
				
				if(is_dir(realpath($this->getUploadRootDir().'/'.$channel->getId())) == false)
				{
					mkdir($this->getUploadRootDir().'/'.$channel->getId());
				}
					
				if(is_dir(realpath($video->getLocation())) == false)
				{
					mkdir($video->getLocation());
				}
				
				$tempimage = @imagecreatefromjpeg('http://img.youtube.com/vi/'.$ytlink->getLink().'/0.jpg');
				
				//safe temporaly
				$tempextension = 'jpg';
				$tempname = $user->getId().'.'.$tempextension;

				if($tempimage)
				{
					$imageratio = imagesx($tempimage)/imagesy($tempimage);
				
					// cut 19/9 ratio
					if($imageratio > 16/9){
						$tempsrcy = imagesy($tempimage);
						$tempsrcx = floor($tempsrcy * 16/9);
					}
					else{
						$tempsrcx = imagesx($tempimage);
						$tempsrcy = floor($tempsrcx * 9/16);
					}
				
					$newsmalimg = @imagecreatetruecolor(160,90);
					$newbigimg = @imagecreatetruecolor(640,360);
				
					$startx = abs(floor(($tempsrcx-imagesx($tempimage))/2));
					$starty = abs(floor(($tempsrcy-imagesy($tempimage))/2));
				
					@imagecopyresampled($newsmalimg, $tempimage, 0, 0, $startx, $starty, 160, 90, $tempsrcx, $tempsrcy);
					@imagecopyresampled($newbigimg, $tempimage, 0, 0, $startx, $starty, 640, 360, $tempsrcx, $tempsrcy);
				
					@imagejpeg($newsmalimg, $video->getLocation().'/../'.$video->getId().'_tiny.jpg', 75);
					@imagejpeg($newbigimg, $video->getLocation().'/../'.$video->getId().'_big.jpg', 80);
				
				}
				
				return $this->redirect($this->generateUrl('video_list'));
			}
			else{
				$this->get('session')->setFlash('notice', 'Ungültige Eingabe!');
			}
		}
		
		return $this->render('FlouVideoManagerBundle:Video:ytlink.html.twig', array(
				'form' => $form->createView(),
		));
	}
	
	protected function getUploadRootDir()
	{
		// the absolute directory path where uploaded documents should be saved
		return $this->container->getParameter('upload.dir.absolute').'/videos';
	}
	
	protected function getUploadDir()
	{
		// get rid of the __DIR__ so it doesn't screw when displaying uploaded doc/image in the view.
		return 'uploads/videos';
	}
	
	protected function safeOnServer($video)
	{
		$video->setFilename(basename($video->file->getClientOriginalName()));
		 
		$prefix = $video->getChannel()->getId().'/'.strval(time());
		 
		$video->file->move($this->getUploadRootDir().'/'.$prefix, $video->getFilename());
		 
		$video->setLocation(realpath($this->getUploadRootDir()).'/'.$prefix.'/');
		// predefine http (the full servername will be set in the controller)
		$video->setHttp('http://'.$_SERVER['SERVER_NAME'].$this->generateUrl('root').$this->getUploadDir().'/'.$prefix.'/'.$video->getFilename());
		
		
		$video->setEnabled(false);
		$video->setUploadtime(new \DateTime("now"));
		
		$this->file = null;
	}
	
	protected function createThumb($channel, $video)
	{
		try{
			
			HelperController::createPath($this->getUploadRootDir().'/'.$channel->getId());
			HelperController::createPath($video->getLocation());
			
			$statement = $this->container->getParameter('ffmpeg.dir').' -i '.$video->getHttp().' -itsoffset 4 -vcodec mjpeg -vframes 1 -an -f rawvideo -s 480x360 -ss 0:0:5 -y "'.$video->getLocation().'/../'.$video->getId().'_big.jpg"';
			exec($statement, $returnvar);
			$statement = $this->container->getParameter('ffmpeg.dir').' -i '.$video->getHttp().' -itsoffset 4 -vcodec mjpeg -vframes 1 -an -f rawvideo -s 480x360 -ss 0:0:5 -y "'.$video->getLocation().'/../'.$video->getId().'_tiny.jpg"';
			exec($statement, $returnvar);
		}
		catch(Exception $e)
		{
			
		}
	}
	
	protected function encodeDuration($time)
	{
		$seconds = $time%60;
		$minutes = (($time-$seconds)/60)%60;
		$hours = $time - ($seconds) - (60*$minutes);
		return sprintf("%02d", $hours).':'.sprintf("%02d", $minutes).':'.sprintf("%02d", $seconds);
	}
	
	protected function setDuration($video)
	{
		ob_start();
		passthru($this->container->getParameter('ffmpeg.dir').' -i '.$video->getHttp().' 2>&1');
		$duration = ob_get_contents();
		ob_end_clean();
		
		$search = "/Duration: (.*?),/";
		$duration = preg_match($search, $duration, $matches, PREG_OFFSET_CAPTURE, 3);
		
		if(key_exists(1, $matches))
		{
			$video->setDuration(substr($matches[1][0], 0, strlen($matches[1][0])-3));
		}
		else 
		{
			$video->setDuration('00:00:00');
		}
	}
	
	protected function getS3UploadParam($bucket, $redirect, $path, $flash)
	{
		// Keep this secure
		S3::setAuth($this->container->getParameter('s3.public.key'), $this->container->getParameter('s3.private.key'));
	
		$lifetime = 3600; // Period for which the parameters are valid
		$maxFileSize = (1024 * 1024 * 600); // 600 MB
	
		$metaHeaders = array('uid' => 123);
		$requestHeaders = array(
				'Content-Type' => 'application/octet-stream',
				'Content-Disposition' => 'attachment; filename=${filename}'
		);
	
		$params = S3::getHttpUploadPostParams(
				$bucket,
				$path,
				S3::ACL_PUBLIC_READ,
				$lifetime,
				$maxFileSize,
				$redirect, // Or a URL to redirect to on success
				$metaHeaders,
				$requestHeaders,
				$flash // False since we're not using flash
		);
	
		return $params;
	}
}
