<?php 
namespace Go;

class SocialMedia
{
	public static function clean($data){
		$data = trim($data);

 		return $data;
	}

	public static function youtube($string,$type=[]){  //link or id

		    if(!empty($type)){

	    	     foreach ($type as $key => $value) {

	   				$type['all'] .= 	$key.'='."'$type[$key]'" ;

				 }

            }else{

            	$type['all'] .= 'width=640' . " ";
            	$type['all'] .= 'height=360' . " ";
            	$type['all'] .= 'frameborder=0' . " ";
            }

            $params = SocialMedia::clean($string);
                    
            $params = str_replace("https://www.youtube.com/watch?v=", "", $params);

            return "<iframe ".$type['all']." src='//www.youtube.com/embed/$params'></iframe>";

	}

		public static function vimeo($string,$type=[]){  //link or id

		    if(!empty($type)){

	    	     foreach ($type as $key => $value) {
	    	     	
	   				$type['all'] .= 	$key.'='."'$type[$key]'" ;

				 }

            }else{

            	$type['all'] .= 'width=640' . " ";
            	$type['all'] .= 'height=360' . " ";
            	$type['all'] .= 'frameborder=0' . " ";
            }

            $params = SocialMedia::clean($string);
                    
            $params = str_replace("https://vimeo.com/", "", $params);

            return "<iframe ".$type['all']."  src='https://player.vimeo.com/video/$params' webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>";

	}
}