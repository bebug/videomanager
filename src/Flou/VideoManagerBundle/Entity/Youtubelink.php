<?php

namespace Flou\VideoManagerBundle\Entity;

class Youtubelink
{
	private $link;
	
	public function setLink($link)
	{
		$this->link = $link;
	}
	
	public function getLink()
	{
		return $this->link;
	}
}