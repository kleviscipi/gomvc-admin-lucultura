<?php
namespace Go;

use Go\ApiController as ApiController;
use Go\Create as Create;

/**
* klevis cipi
*/
class PermissionsApiController extends ApiController
{
    
	public function index(){

	    $data['title'] = 'INdex';

		$this->json($data);
	}

	public function addrole(){

		if(!empty($_POST['id']) && !$_POST['id'] = null){
			$updatethis = $this->Model->updaterole($_POST);
			if($updatethis){
				$response['sms'] 	= $this->Language->get('updaterole_success');
				$response['error']	=0;
			}else{
				$response['sms'] 	= $this->Language->get('updaterole_error');
				$response['error']	=0;
			}

		}else{
			$getrole = $this->Model->thisrole($_POST);
			if($getrole){
				$response['sms'] = $this->Language->get('exist_role');
				$response['error']	= 1;
			}else{
				$addrole = $this->Model->addrole($_POST);
				if($addrole){
					$response['sms'] 	= $this->Language->get('addrole_success');
					$response['error']	= 0;
				}else {
					$response['sms'] = $this->Language->get('addrole_error');
					$response['error']	= 1;

				}
			}
		}

		

		$this->json($response);
	}

	public function addpermissions(){
		$post=$_POST;

		if(!empty($post['id']) && !$post['id'] = null){
			$updatethis = $this->Model->updatepermissions($_POST);
			if($updatethis){
				$response['sms'] 	= $this->Language->get('updateperm_success');
				$response['error']	=0;
			}else{
				$response['sms'] 	= $this->Language->get('updateperm_error');
				$response['error']	=0;
			}
		}else{
			$getthis = $this->Model->thispermissions($_POST);
			if($getthis){

				$response['sms'] = $this->Language->get('exist_perm');
				$response['error']	= 1;
			}else{
				$addrole = $this->Model->addpermissions($post);
				if($addrole){
					$tablecolumns = $this->Model->schema($post['controller'])->columns;
					$createfiles = Create::SystemFiles($post['controller'],$tablecolumns);

					if($createfiles){
						$response['files'] = "Files created successfully?";
					}else{
						$response['files'] = "Files exists";
					}
								  
					$response['sms'] 	= $this->Language->get('addperm_success');
					$response['error']	=0;
				}else {
					$response['sms'] = $this->Language->get('addrole_error');
					$response['error']	= 1;
				}
			}

		}
		$this->json($response);
	}
	public function getroles(){
		$id = $_POST['id'];
			if(!empty($id)){
				$getrole = $this->Model->getrole($id);
				$response['dataone'] 	= $getrole;
				$response['action'] 	= true;
			}	
			$getroles = $this->Model->getroles();
			if(empty($getroles)){
				$response['data'] 	= '';
				$response['error']	=1;
			}else{
				$response['data'] 	= $getroles;
				$response['error']	=0;
			}
		$this->json($response);
	}
	public function getrolesadd(){

		$getroles = $this->Model->getrolesadd();
		if(empty($getroles)){
			$response['data'] 	= '';
			$response['error']	=1;
		}else{
			$response['data'] 	= $getroles;
			$response['error']	=0;
		}

		$this->json($response);
	}
	public function getpermissions(){
		$id = $_POST['id'];
		if(!empty($id)){
			$getperm = $this->Model->getpermission($id);
			$response['dataone'] 	= $getperm;
			$response['action'] 	= true;
		}
		$getperms = $this->Model->getpermissions();

		if(empty($getperms)){
			$response['data'] 	= '';
			$response['error']	=1;
		}else{
			$response['data'] 	= $getperms;
			$response['error']	=0;
		} 
		
		$this->json($response);
	}
	public function deleterole(){
		$id = $_POST['id'];
		$deleterole = $this->Model->deleterole($id);
		if($deleterole){
			$response['sms'] = $this->Language->get('delete_role_success');
			$response['error']=0;
		}else{
			$response['sms'] = $this->Language->get('delete_role_error');
			$response['error']=1;
		}
		$this->json($response);

	}
	public function rolestatusupdate(){
		$id = $_POST['id'];
		$status = $_POST['status'];
		$update = $this->Model->rolestatusupdate($id,$status);
		if($update){
			$response['sms'] = $this->Language->get('updaterole_success');
			$response['error']=0;
		}else{
			$response['sms'] = $this->Language->get('updaterole_error');
			$response['error']=1;
		}
		$this->json($response);

	}
	public function superstatusupdate(){

		$id = $_POST['id'];
		$status = $_POST['superstatus'];
		$havesuper = $this->Model->ifhavesuperuser();
		if($havesuper){
			$response['sms'] = "You can't insert more one superuser!";
			$response['error']=1;
		}else{
			$update = $this->Model->superstatusupdate($id,$status);
			if($update){
				$response['sms'] = $this->Language->get('updaterole_success');
				$response['error']=0;
			}else{
				$response['sms'] = $this->Language->get('updaterole_error');
				$response['error']=1;
			}			
		}

		$this->json($response);		
	}
	public function deletepermissions(){
		$id = $_POST['id'];
		$delete = $this->Model->deletepermissions($id);
		if($delete){
			$response['sms'] = $this->Language->get('delete_perm_success');
			$response['error']=0;
		}else{
			$response['sms'] = $this->Language->get('delete_perm_error');
			$response['error']=1;
		}
		$this->json($response);

	}
// permission to user
	public function permissionsuser(){
		$id = $_POST['id'];
		if(empty($id)){
				$response['data'] 	= '';
				$response['sms'] 	="Error no id....";
				$response['error']	=1;		
		}else{
			$getperms = $this->Model->permissionsuser($id);

			if(empty($getperms)){
				$response['data'] 	= '';
				$response['error']	=1;
			}else{
				$response['data'] 	= $getperms;
				$response['error']	=0;
			} 
		}

		
		$this->json($response);
	}

	public function user_permisions(){
		$id = $_POST['user_id'];
		if(empty($id)){
		    $response['sms'] 	= $this->Flash->get('getuser_perms','/');
			$response['error']	=1;
		}else{

			$gtpermsuser = $this->Model->user_permisions($id);
			if(empty($gtpermsuser)){
				$response['data'] 	= '';
				$response['error']	=1;
			}else{
				$response['data'] 	= $gtpermsuser;
				$response['error']	=0;
			} 			
		}

		
		$this->json($response);
	}
	public function updatestatus(){
		$id 	= $_POST['id'];
		$call 	= explode("-",$id);
		$id 	= $call[1];
		$status = $call[2];
		$userid = $call[3];

		if(empty($id) || empty($status) || empty($userid)){
			$response['sms'] 	= $this->Language->get('update_st_error');
			$response['error']	=1;
		}else{

			$updatestatus = $this->Model->updatestatus($id,$status,$userid);
			if($updatestatus){
				$response['sms'] 	= $this->Language->get('update_st_success');
				$response['error']	=0;
			}else{
				$response['sms'] 	= $this->Language->get('update_st_error');
				$response['error']	=1;			
			}			
		}
		$this->json($response);
	}

	public function deleteuserpermisions(){
		$id 		= $_POST['id'];
		$userid 	= $_POST['userid'];
		if(empty($id)  || empty($userid)){
			$response['sms'] 	= $this->Language->get('delete_st_error');
			$response['error']	=1;
		}else{
			$updatestatus = $this->Model->deleteuserpermisions($id,$userid);
			if($updatestatus){
				$response['sms'] 	= $this->Language->get('delete_st_success');
				$response['error']	=0;
			}else{
				$response['sms'] 	= $this->Language->get('delete_st_error');
				$response['error']	=1;			
			}			
		}
		$this->json($response);
	}

		public function adduserpermissions(){
			$id 		= $_POST['id'];
			$iduser 	= $_POST['iduser'];
			$roleid 	= $_POST['role_id'];

		if(empty($id) || empty($iduser) ||  empty($roleid)){
			$response['sms'] 	= $this->Language->get('add_st_error');
			$response['error']	=1;
		}else{
			$ifuserpermision = $this->Model->ifuserpermision($id,$iduser);
			if($ifuserpermision){
				$response['sms'] 	= $this->Language->get('addcheck_st_error');
				$response['error']	=1;				
			}else{
				$addpermission = $this->Model->adduserpermissions($id,$iduser,$roleid);
				if($addpermission){
					$response['sms'] 	= $this->Language->get('add_st_success');
					$response['error']	=0;
				}else{
					$response['sms'] 	= $this->Language->get('add_st_error');
					$response['error']	=1;			
				}					
			}
		
		}
		$this->json($response);
	}
//permission to role

	public function permissionsrole(){
		$id = $_POST['id'];
		if(empty($id)){

			$response['data'] 	= '';
			$response['sms'] 	= 'Error..... no id';
			$response['error']	=1;
		}else{
			$getperms = $this->Model->permissionsrole($id);

			if(empty($getperms)){
				$response['data'] 	= '';
				$response['error']	=1;
			}else{
				$response['data'] 	= $getperms;
				$response['error']	=0;
			} 
		}

		
		$this->json($response);
	}

	public function role_permisions(){
		$id = $_POST['role_id'];
		if(empty($id)){
		    $response['sms'] 	= $this->Flash->get('getuser_perms','/');
			$response['error']	=1;
		}else{

			$gtpermsrole = $this->Model->role_permisions($id);
			if(empty($gtpermsrole)){
				$response['data'] 	= '';
				$response['error']	=1;
			}else{
				$response['data'] 	= $gtpermsrole;
				$response['error']	=0;
			} 			
		}

		
		$this->json($response);
	}
	public function updatestatusrole(){
		$id 	= $_POST['id'];
		$call 	= explode("-",$id);
		$id 	= $call[1];
		$status = $call[2];
		$roleid = $call[3];

		if(empty($id) || empty($status) || empty($roleid)){
			$response['sms'] 	= $this->Language->get('update_st_error');
			$response['error']	=1;
		}else{

			$updatestatus = $this->Model->updatestatusrole($id,$status,$roleid);
			if($updatestatus){
				$response['sms'] 	= $this->Language->get('update_st_success');
				$response['error']	=0;
			}else{
				$response['sms'] 	= $this->Language->get('update_st_error');
				$response['error']	=1;			
			}			
		}
		$this->json($response);
	}

	public function deleterolepermisions(){
		$id 		= $_POST['id'];
		$roleid 	= $_POST['roleid'];
		if(empty($id)  || empty($roleid)){
			$response['sms'] 	= $this->Language->get('delete_st_error');
			$response['error']	=1;
		}else{
			$updatestatus = $this->Model->deleterolepermisions($id,$roleid);
			if($updatestatus){
				$response['sms'] 	= $this->Language->get('delete_st_success');
				$response['error']	=0;
			}else{
				$response['sms'] 	= $this->Language->get('delete_st_error');
				$response['error']	=1;			
			}			
		}
		$this->json($response);
	}

		public function addrolepermissions(){
			$id 		= $_POST['id'];
			$roleid 	= $_POST['role_id'];

		if(empty($id) ||  empty($roleid)){
			$response['sms'] 	= $this->Language->get('add_st_error');
			$response['error']	=1;
		}else{
			$ifrolepermision = $this->Model->ifrolepermision($id,$roleid);
			if($ifrolepermision){
				$response['sms'] 	= $this->Language->get('addcheck_st_error');
				$response['error']	=1;				
			}else{
				$addpermission = $this->Model->addrolepermissions($id,$roleid);
				if($addpermission){
					$response['sms'] 	= $this->Language->get('add_st_success');
					$response['error']	=0;
				}else{
					$response['sms'] 	= $this->Language->get('add_st_error');
					$response['error']	=1;			
				}					
			}
		
		}
		$this->json($response);
	}
	public function updatesublink(){
		$postid 	= $_POST['id'];
		$val 	= $_POST['val'];
		$call 	= explode("-",$postid);
		$id 	= $call[1];

		if(empty($id) || empty($val)){
			$response['sms'] 	= $this->Language->get('update_st_error');
			$response['error']	=1;
		}else{

			$updatesublink = $this->Model->updatesublink($id,$val);
			if($updatesublink){
				$response['sms'] 	= $this->Language->get('update_st_success');
				$response['error']	=0;
			}else{
				$response['sms'] 	= $this->Language->get('update_st_error');
				$response['error']	=1;			
			}			
		}
		$this->json($response);
	}
	public function visits(){
		$response['data'] = $this->Model->visits();
		$response['error'] =0;
		$this->json($response);
	}
	public function updateip(){
		$state  = $_POST['state'];
		$id 	= $_POST['id'];
		$update =  $this->Model->updateip($id,$state);
		if($update){
			$response['sms'] 	= "Ip state updated successfully";
			$response['error']	=0;
		}else{
			$response['sms'] 	= "Ip Not Updatet";
			$response['error']	=1;
		}

		$this->json($response);
	}
}