<?php 
namespace Go;
use Go\Error as Error;
use Go\Flash as Flash;
use Go\Session as Session;

class Template
{

	public static function View($folder,$file,$data = null, $error = null){
		$msg = new Flash();
		self::Header($data,$error);//start header
			$view  = ROOT_VIEWS.$folder.DIR.$file.'.php';
	 		if(file_exists($view)){
	 			  
	 			 require_once $view;
	 		}else{
	 		   echo Error::display("ERROR......GENERETING FILE ( $file.php ), DON'T EXIST ");
	 		   die;	
	 		}
 		self::Footer($data,$error); //start header
	}
	public  function Header($data='',$error=''){

		 $header =ROOT.DIR.DIR_TEMPLATE.DIR.TEMPLATE.DIR.'header.php';
		
		 if(file_exists($header)){
		 	return require_once $header;
		 }else{
		 	echo Error::display("ERROR......GENERETING FILE ($header.php), DON'T EXIST ");
 		    die;	
		 }
		 
	}
	public  function Footer($data='',$error=''){

		$footer =ROOT.DIR.DIR_TEMPLATE.DIR.TEMPLATE.DIR.'footer.php';
		 
		if(file_exists($footer)){
		 	return require_once $footer;
		}else{
		 	echo Error::display("ERROR......GENERETING FILE ($footer.php), DON'T EXIST ");
 		    die;
		}
		
	}

}