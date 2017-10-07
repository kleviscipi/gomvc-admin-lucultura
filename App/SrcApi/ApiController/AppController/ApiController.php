<?php 
namespace Go;
use Go\Session as Session;
use Go\Language as Language;
use Go\Validator as Validator;
use Go\Crypt as Crypt;
use Go\Link as Link;
use Go\Flash 	as Flash;

class ApiController extends Validator
{
	public $Model;
	public $Language;
	public $Session;
	public $Folder;

	public function __construct($Model,$Folder)
	{
		$this->before();
		$this->apikey($_POST['key']);
		$this->has();
		$this->Model = $Model;
		$this->Folder = $Folder;
		$this->Language= new Language($this->Folder); //init language
		$this->msg=new Flash;
	}

	public function before()
	{
		if(!$this->afterajax()){
			$data['status'] = "fail";
			$data['error'] 	= 1;
			$data['sms']	= "You not are a human";
		die(json_encode($data));
		}
	}
	public function afterajax()
	{
	    return isset( $_SERVER['HTTP_X_REQUESTED_WITH'] );
	}
	public function after()
	{
		
	}
	public function json($data)
	{  
		if($data['error'] ==0){
			$data['status'] 	= "success";
			$data['code'] 		= "200";
		}else if($data['error'] ==1){
			$data['status'] 	= "fail";
			$data['code'] 		= "500";
		}else if($data['error'] ==3){
			$data['status'] 	= "nodb";
			$data['code'] 		= "500";
		}else{
			$data['status'] 	= "nohuman";
			$data['code'] 		= "500";
		}
		
		echo json_encode($data);
	}

	public function apikey($key)
	{	
		if(empty($key)){
			$key = $_GET['key'];
			if(empty($key)){
				$data['status'] = "fail";
				$data['error'] 	= 1;
				$data['sms']	= "You not are a human";
			die(json_encode($data['status']));
			} 
		}
		$from_call = Crypt::decrypt(KEY_API,$key);

		if($from_call){
			return true;
		}else{
				$data['status'] = "fail";
				$data['error'] 	= 1;
				$data['sms']	= 'You don\'t have acces of this link';
			die(json_encode($data));
		}
	}

	public function has() {
		if(!empty($_POST['work'])){
			$work = $_POST['work'];
		}else{
			$work = "";
		}
		if(!empty($_POST['from'])){
			$from = $_POST['from'];
		}else{
			$from = "";
		}
		
		if(empty( $work ) ) {
			if($_GET['work']){
				$work = $_GET['work'];
			}else{
				$work = "";
			}
			if($_GET['from']){
				$from = $_GET['from'];
			}else{
				$from = "";
			}	
		}
		if(empty( $from ) ) {
			$from = $_GET['from'];	
		}
		if(empty( $from ) ) {
			
	       if( $this->ifsession()->yes && $work == "action" ){
		       	$response['error'] = 1;
		       	$response['sms'] = "You are just a guest, don't have permissions to actions!";
		       	die( json_encode( $response ) );

	       }
		}

    }

    public function ifsession(){
		$user 		= Session::get('name');
		$id 		= Session::get('iduser');
		if( empty( $user ) && empty( $id ) ){
			$ifsession['yes'] = true;
			return (object) $ifsession;
		}else{
			$ifsession['yes'] = false;
			return (object) $ifsession;
		}
	}

 

}