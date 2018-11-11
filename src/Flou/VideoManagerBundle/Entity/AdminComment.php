<?php 
namespace Flou\VideoManagerBundle\Entity;
class AdminComment{
	
	private $message;
	private $name;
	
	public function getMessage(){
		return $this->message;
	}
	
	public function setMessage($message){
		$this->message = $message;
	}
	
	public function getName(){
		return $this->name;
	}
	
	public function setName($name){
		$this->name = $name;
	}
}
?>