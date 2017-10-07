<?php

namespace Go;

use Go\ApiController as ApiController;
use Go\Password as Password;
use Go\Link as Link;
use Go\Session as Session;
use Go\Ip as Ip;
use Go\Crypt as Crypt;
/**
* klevis cipi
*/
class AdminApiController extends ApiController
{

	public function index(){

	}

	public function start(){
		$data['text']=  "from api";
		$this->json($data);
	}

	public function add(){
		$post 	= [];
		$post = [
			'name'		=>$_POST['name'],
			'subname'	=>$_POST['subname'],
			'email'		=>$_POST['email'],
			'username'	=>$_POST['username'],
			'role_id'	=>$_POST['role'],
			'password'	=>Password::make($_POST['password'])
		];
		$thisuser  =$this->Model->thisuser($post);
		if($thisuser){
				$username	=	$post['username'] ;
				$email		=	$post['email'] ;

				$response['sms'] =$this->Language->get('add_checkuser').  $username. "," . $email ;
				$response['error'] = 1;
		}else{
			$save=$this->Model->addadmin($post);
			
			if($save){
				$response['sms'] = $this->Language->get('add_success') ;
				$response['error'] = 0;
			}else{
				$response['sms'] = $this->Language->get('add_error');
			  	$response['error'] = 1;

			}
		}

		$response['post']=$post;
		$this->json($response);
	}
	public function login(){
		$email 		= $_POST['email'];
		$password 	= $_POST['password'];
		$user = $this->Model->login($email);
		$count = count($user);
		if($count > 0 ){
			$verify = Password::verify($password,$user->password);
			if($verify){
				Session::set('name',$user->name);
				Session::set('username',$user->username);
				Session::set('iduser',$user->id);
				Session::set('email',$user->email);
				Session::set('superuser',$user->superuser);
				Session::set('logged',"User is loged");
				$this->Model->access(Ip::getIp(),Session::get('username'),Session::get('email'),Session::get('iduser'),'t');
			    $data['sms'] = "Logged successfully." . Session::get('logged');
				$data['error'] = 0;
				$data['superuser'] = Session::get('superuser');
			}else{
				$data['sms'] = "Password dont match";
				$data['error'] = 1;
			}
		}else{
			$data['sms'] = "This email don-t exist on the table";
			$data['error'] = 1;
		}
		$this->json($data);
	}
	public function loginguest(){
		Session::set('guest','Guest');
		$data['sms'] = "Logged successfully." . Session::get('guest');
		$data['error'] = 0;
		
		$this->json($data);
	}

	public function logout(){
		$this->Model->access(Ip::getIp(),Session::get('username'),Session::get('email'),Session::get('iduser'),'f');
		Session::destroy();
		$response['title'] = "Thank you";
		$response['body'] = "Have a nise day. Logout successfully";
		$response['error'] = 0;
		$this->json($response);
	}
	public function getusers(){
		$getusers  = $this->Model->getusers();
		$response['data'] 	= $getusers;
		$response['error'] 	= 0;
		$this->json($response);

	}
	public function deleteuser(){
		$id = $_POST['id'];
		
		if(empty($id) || $id==null){
			$response['sms'] = $this->Language->get('delete_user_error');
			$response['error']=1;
		}else{
			$delete = $this->Model->deleteuser($id);
			if($delete){
				$controller  = "Admin";
				$description = "Deleted 1 user";
				$this->Model->insertactions('Delete',$controller,$description,Session::get('iduser'),$count);
				$response['sms'] = $this->Language->get('delete_user_success');
				$response['error']=0;

			}else{
				$response['sms'] = $this->Language->get('delete_user_error');
				$response['error']=1;

			}
		}
		$this->json($response);
	}
	public function setrole(){
		$id = $_POST['id'];
		$val = $_POST['val'];
		$success = $this->Model->setrole($id,$val);

		if($success){
			$response['sms'] 	= $this->Language->get('updaterole_success');
			$response['error']  = 0;
		}else{
			$response['sms'] 	= "Role not update!";
			$response['error']  = 1;
		}
		$this->json($response);
	}

	public function updateuser(){
		$post 	= [];
		$post = [
			'name'		=>$_POST['name'],
			'subname'	=>$_POST['subname'],
			'email'		=>$_POST['email'],
			'username'	=>$_POST['username'],
			'id'		=>$_POST['id'],
		];
		$thisuser  =$this->Model->thisuser($post);
		if($thisuser){
				$username	=	$post['username'] ;
				$email		=	$post['email'] ;

				$response['sms'] =$this->Language->get('add_checkuser').  $username. "," . $email ;
				$response['error'] = 1;
		}else{
			$save=$this->Model->updateuser($post);
			
			if($save){
				$response['sms'] = $this->Language->get('update_success') ;
				$response['error'] = 0;
			}else{
				$response['sms'] = $this->Language->get('add_error');
			  	$response['error'] = 1;

			}
		}

		$this->json($response);
	}

	public function language(){
		$lang = $_POST['value'];
		if(!empty($lang)){
			Session::destroy('language');
			Session::set('language',$lang);
			if(Session::get('language')){
				$response['sms']= "You have set the language $lang successfully!";
				$response['error'] = 0;
			}else{
				$response['sms']= "Error language is not set!";
				$response['error'] = 1;
			}
		}

	    $this->json($response);
	}
	public function notifications(){
		$notice  = $this->Model->notifications();
		$response['count']  = $notice;
		$response['title'] 	="Important Unread notifications ";
		$response['sms'] 	="You have $notice Unread notifications!";
		$response['error']  = 0;
		$response['data'] 	= '';
		$this->json($response);
	}
	public function updatenotice(){
		$set = $_POST['set'];
		$update = $this->Model->updatenotice($set);
		if($update){
			$response['data']= "";
			$response['error'] = 0;
		}else{
			$response['data']= "";
			$response['error'] = 1;			
		}
		$this->json($response);
	}
	public function notificationlist(){
		$list = $this->Model->notificationlist();
		$response['data'] = $list;
		$response['error'] = 0;
		$this->json($response);

	}
	public function notificationday(){
		$date = date('Y-m-d');
		$list = $this->Model->notificationday($date);
		$response['data'] = $list;
		$response['error'] = 0;
		$this->json($response);
	}
	public function statistics(){
		$list = $this->Model->statistics();
		$response['data'] = $list;
		$response['error'] = 0;
		$this->json($response);
	}
	public function cronjobs(){
		$list = $this->Model->cronjobs();
		$response['data'] = $list;
		$response['error'] = 0;
		$this->json($response);		
	}
	public function access(){
		$list = $this->Model->access();
		$response['data'] = $list;
		$response['error'] = 0;
		$this->json($response);		
	}
	public function actions(){
		$list = $this->Model->actions();
		$response['data'] = $list;
		$response['error'] = 0;
		$this->json($response);

	}

	public function search(){
		$words = $_POST['words'];
		$list = $this->Model->search($words);
		$response['data'] = $list;
		$response['error'] = 0;
		$this->json($response);

	}
	public function redirects(){
		$words = $_POST['word'];
		if($words){
		$id = Crypt::Tokenid($words);
		$response['data'] = $id;
		$response['error'] = 0;
		}else{
			$response['error'] = 1;
		}

		$this->json($response);
	}

	public function profiles(){
		$oldpass = $_POST['oldpass'];
		$id = Session::get('iduser');
		if(!empty($id)){
		    $thisuser = $this->Model->passwordcheck($id);
			$verify = Password::verify($oldpass,$thisuser->password);	
			if($verify){
				$response['data'] =$verify;
				$response['error'] = 0;
			}else{
				$response['data'] =$verify;
				$response['error'] = 1;
			}
		}else{
		  $response['error'] = 1;	
		}
		$this->json($response);
	}

	public function savepassword(){
		$oldpass = $_POST['oldpass'];
		$newpass = $_POST['newpass'];
		$id = Session::get('iduser');
		if(!empty( $id ) && !empty( $oldpass ) && !empty( $newpass ) ){
		    $thisuser = $this->Model->passwordcheck($id);
			$verify = Password::verify($oldpass,$thisuser->password);	
			if($verify){
				$newpass= Password::make($newpass);
				$update = $this->Model->savepassword($id,$newpass);
				$response['sms'] ="Password modified successfully";
				$response['error'] = 0;
			}else{
				$response['sms'] ="Passwords don-t match";
				$response['error'] = 1;
			}
		}else{
		  $response['sms'] ="Empty passwords";
		  $response['error'] = 1;	
		}
		$this->json($response);
	}
	public function saveprofile(){
		$name 		= $_POST['name'];
	    $subname 	= $_POST['subname'];
		$username 	= $_POST['username'];
		$email 		= $_POST['email'];
		$id = Session::get('iduser');
		$thisuser  =$this->Model->thisuserupdate($id,$email,$username);
		if($thisuser){
				$response['sms'] =$this->Language->get('add_checkuser').  $username. "," . $email ;
				$response['error'] = 1;
		}else{
			$save=$this->Model->updateadmin($id,$name,$subname,$username,$email);
			
			if($save){
				$response['data'] = $this->Model->userforprofile($id);
				$response['sms'] = $this->Language->get('add_success') ;
				$response['error'] = 0;
			}else{
				$response['sms'] = $this->Language->get('add_error');
			  	$response['error'] = 1;

			}
		}
		$this->json($response);

	}
}