<?php
namespace Go;

class Validator
{

	public static function email($email)
	{
		if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
			return false;
		}else{
			return true;
		}
	}

	public static function string($string,$type=[])
	{	
		$count = strlen($string);
		if(is_array($type) && !empty($type)){
			if(array_key_exists('length',$type))
			{
				if($count > $type['length']){
					$return['length'] =  true;
				}else{
					$return['length'] = false;
				}
			}

		}

		$return['string'] = $string;
		$return['count'] = $count;
		return (object) $return;	
	}
	public static function words($words){

		if(!empty($words)){
			$return['oupper'] = strtoupper($words);
			$return['lower'] = strtolower($words);
			$return['ucf'] = ucfirst($words);
			$return['ucw'] = ucwords($words);
			
		}

		return (object) $return;
	}

	public static function ifempty($string){
		$string = $this->check_input($string);
		if(empty($string)){
			return TRUE;
		}else{
			return FALSE;
		}
	}
	public function check_input($data) {
		  $data = trim($data);
		  $data = stripslashes($data);
		  $data = htmlspecialchars($data);
	  return $data;
	}

	public static function request($type = null){
		// return object tru or false: example 
		// call example $this::request()->get
		/*
		if($this::request()->get) ? yes : no;  
		*/  
			$post = $_SERVER["REQUEST_METHOD"];
			if($post =="POST"){
				$return['post'] = TRUE;
			}else{
				$return['post'] = FALSE;
			}
			if($post=="GET"){
				$return['get'] = TRUE;
			}else{
				$return['get'] = FALSE;
			}
			if($post=="DELETE"){
				$return['delete'] = TRUE;
			}else{
				$return['delete'] = FALSE;
			}
			return (object) $return;  

	}
}