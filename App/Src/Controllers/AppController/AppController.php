<?php
namespace Go;

use Go\PageModel as PageModel;
use Go\Session as Session;
use Go\Language as Language;
use Go\Validator as Validator;
use Go\Flash 	as Flash;


class AppController extends Validator
{
	public $Model;
	public $Folder;
	public $Language;
	public $Session;
	public $msg;
	public $menupermited;
	public function __construct($Model,$Folder)
	{	
		$this->Model = $Model;
		$this->Folder = $Folder;
		$this->Language= new Language($this->Folder); //init language
		$this->msg=new Flash;
		$this->menupermited =$this->initialize(
			[
				'Admin'=>['login','users'],
				'Books'=>['index'],
				'Permissions'=>['index','rolepermissions'] 
			]
			);
		$this->block();
		$this->before($this->menupermited);
		$this->after();

		
	}

	public function before($methods =[]){


		if(!empty( $this->is_start()->user ) && !empty( $this->is_start()->email ) && !empty( $this->is_start()->id ) ){
			   $haspermisions = $this->Model->is_permited()->permited->count;

			   if($haspermisions < 1 && !$this->is_start()->name =='admin'){
			   		$this->msg->error('You dont have permisions for this page!!?','/');
			   }
		}else{
		   if( empty( $GLOBALS['method'] ) ) $GLOBALS['method'] = "index";

		   if(in_array( strtolower( $GLOBALS['method'] ) , $methods[ucfirst($GLOBALS['class'])] ) ){
		   		if( array_key_exists( ucfirst( $GLOBALS['class'] ), $methods ) ){
		   			Session::set('guest','nothuman');
		   		}else{
					if(!empty(Session::get('guest'))){
						Session::destroy('guest');
					}
				    $this->msg->error('You dont have permisions for this page!!','/');

		   		}
		   	}else{
	   			if(!empty(Session::get('guest'))){
					Session::destroy('guest');
				}
				$this->msg->error('You dont have permisions for this page....','/');
		   	}
		}


	}

	public function after(){

		if(empty( $this->is_start()->id ) ){
		  return (object) $GLOBALS['menupermited']= $this->menupermited; 
			
		}else{
		  return $GLOBALS['menu'] = $this->Model->menu(); 
		}
	   
	
	}

	public function initialize($access= []){
		return  $access;
	}

	public function is_start(){
		$start = [];
		$start['id'] 		= Session::get('iduser');
		$start['user'] 		= Session::get('username');
		$start['email'] 	= Session::get('email');
		$start['name'] 	= Session::get('name');
		return (Object) $start;
	}

	public function block(){
		if($this->Model->ifblocket()){
			$error = new Error;
			$error->block();
			die();
		}
	}

}