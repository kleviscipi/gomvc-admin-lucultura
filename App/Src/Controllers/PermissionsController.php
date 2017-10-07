<?php

namespace Go;

use Go\AppController as AppController;

/**
* klevis cipi
*/
class PermissionsController extends AppController
{

	public function index(){

	    $data['title'] = 'Permissions';
	    $data['headertitle'] = 'Permissions page';
		
		$this->Language->get('wel');

		Template::View($this->Folder,'Index',$data);
	}


	public function add(){
	    $data['title'] = 'Add Permissions';
	    $data['content-title']="User Permissions";

		Template::View($this->Folder,'Add',$data);	
	}
	public function userpermissions($id){
	    $data['title'] = 'Add Permissions';
		$data['content-title']="User Permissions";
		if(empty($id)){
			$this->msg->error('Empty id or this id don\'t exists', '/');
		}
		$data['user']=$this->Model->getuser($id);

		Template::View($this->Folder,'Userpermissions',$data);	
	}

	public function rolepermissions($id){
	    $data['title'] = 'Add Permissions';
		$data['content-title']="Role Permissions";
		if(empty($id)){
			$this->msg->error('Empty id or this id don\'t exists', '/');
		}
		$data['role']=$this->Model->getrole($id);

		Template::View($this->Folder,'Rolepermissions',$data);	
	}

	public function visits(){

	    $data['title'] = 'Visits';
	    $data['headertitle'] = 'Visits page';
		
		Template::View($this->Folder,'Visits',$data);
	}
}