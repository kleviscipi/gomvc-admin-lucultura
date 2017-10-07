<?php
namespace Go;
use Go\ApiModel as ApiModel;

/**
* klevis cipi
*/
class PermissionsApiModel extends ApiModel
{	

	public function persons(){

		$sql = $this->raw("SELECT * FROM persons");
		$persons=[];

		while ($row = $sql->fetch($this->obj)) {
			$persons[]=$row;
		}

		return $persons;
	}
	public function addrole($post){
		$sql ="INSERT INTO role(name,status) VALUES(:name,:status)";
		$save=$this->pdo->prepare($sql);
		$save->bindValue(':name',ucfirst($post['name']));
		$save->bindValue(':status',	'true');
		$final  =$save->execute();
		if($final){
			return true;
		}else return false;

	}
	public function thisrole($post){
		$name =$post['name'];
		$sql	="SELECT * FROM role WHERE lower(name) = lower('$name')";
		$sql 	= $this->pdo->query($sql);
		while ($row = $sql->fetch($this->obj)) {
			$role=$row;
		}
		if(!empty($role)){
			return true;
		}else{
			return false;
		}
	}
	public function updaterole($post){
		$sql ="UPDATE role SET name = :name WHERE id=:id";
		$save=$this->pdo->prepare($sql);
		$save->bindValue(':name',ucfirst($post['name']));
		$save->bindValue(':id',	$post['id']);
		$final  =$save->execute();
		if($final){
			return true;
		}else return false;

	}

	public function updatesublink($id,$val){
		$sql ="UPDATE permisions SET sublink = :sublink WHERE id=:id";
		$save=$this->pdo->prepare($sql);
		$save->bindValue(':sublink',$val );
		$save->bindValue(':id',	$id );
		$final  =$save->execute();
		if($final){
			return true;
		}else return false;

	}
	public function addpermissions($post){
		$sql ="INSERT INTO permisions(controller,method,param1) VALUES(:controller,:method,:param1)";
		$postcontroller = trim($post['controller']," ");
		$save=$this->pdo->prepare($sql);
		$save->bindValue(':controller',	ucfirst($postcontroller));
		$save->bindValue(':method',	ucfirst($post['method']));
		$save->bindValue(':param1',	$post['param1']);
		$final  =$save->execute();
		if($final){
			return true;
		}else return false;

	}
	public function updatepermissions($post){
		$sql ="UPDATE permisions SET controller = :controller, method = :method,param1 = :param1 WHERE id=:id";
		$save=$this->pdo->prepare($sql);
		$save->bindValue(':controller',	ucfirst($post['controller']));
		$save->bindValue(':method',	ucfirst($post['method']));
		$save->bindValue(':param1',	$post['param1']);
		$save->bindValue(':id',	$post['id']);
		$final  =$save->execute();
		if($final){
			return true;
		}else return false;

	}
	public function thispermissions($post){
		$controller = trim($post['controller']," ");
		$method = trim($post['method']," ");
		$sql	="SELECT * FROM permisions WHERE lower(method) = lower('$method') AND lower(controller) = lower('$controller')";
		$sql 	= $this->pdo->query($sql);
		while ($row = $sql->fetch($this->obj)) {
			$permisions=$row;
		}
		if(!empty($permisions)){
			return true;
		}else{
			return false;
		}
	}
	public function getroles(){
		$sql = $this->raw("SELECT * FROM role  ORDER BY id");
		$roles=[];

		while ($row = $sql->fetch($this->obj)) {
			$roles[]=$row;
		}

		return $roles;
	}
	public function getrolesadd(){
		$sql = $this->raw("SELECT * FROM role where superuser='f'  ORDER BY id");
		$roles=[];
		while ($row = $sql->fetch($this->obj)) {
			$roles[]=$row;
		}
		return $roles;		
	}
	public function getrole($id){
		$sql = $this->raw("SELECT * FROM role WHERE id = $id");
		$role=[];

		while ($row = $sql->fetch($this->obj)) {
			$role[]=$row;
		}
		return $role;
	}
	public function getpermissions(){
		$sql = $this->raw("SELECT * FROM permisions ORDER BY id DESC");
		$perms=[];

		while ($row = $sql->fetch($this->obj)) {
			$perms[]=$row;
		}

		return $perms;
	}
	public function getpermission($id){
		$sql = $this->raw("SELECT * FROM permisions WHERE id = $id");
		$perm=[];

		while ($row = $sql->fetch($this->obj)) {
			$perm[]=$row;
		}

		return $perm;
	}
	public function deleterole($id){
		$sql = "DELETE FROM role WHERE id = $id";
		$sql = $this->pdo->prepare($sql);
		$delete = $sql->execute();
		if($delete){
			return true;
		}else return false;
	}

	public function deletepermissions($id){
		if($this->ifhavethispermission($id,'user_permisions') || $this->ifhavethispermission($id,'role_permisions')){
			$user =$this->ifhavethispermission($id,'role_permisions',true);
			$role =$this->ifhavethispermission($id,'user_permisions',true);
			if($user || $role){
				$sql = "DELETE FROM  permisions WHERE id = $id";
				$sql = $this->pdo->prepare($sql);
				$delete = $sql->execute();
				if($delete){
					return true;
				}else return false;
			}		
		}else{
			$sql = "DELETE FROM  permisions WHERE id = $id";
			$sql = $this->pdo->prepare($sql);
			$delete = $sql->execute();
			if($delete){
				return true;
			}else return false;	
		}

	}
//user mermisssions
	public function permissionsuser($id){
		$sql = $this->raw("SELECT p.*,up.permited,up.user_id AS userid  FROM  permisions AS p LEFT JOIN user_permisions AS up ON (up.permision_id = p.id AND up.user_id = $id)");

		while ($row = $sql->fetch($this->obj)) {
			$perms[]=$row;
		}

		return $perms;
	}
	public function user_permisions($id){
		$sql = $this->raw("SELECT up.*,p.controller,p.method,p.param1 FROM  user_permisions AS up INNER JOIN permisions AS p ON (up.permision_id = p.id) WHERE user_id = $id");
		while ($row = $sql->fetch($this->obj)) {
			$userperms[]=$row;
		}

		return $userperms;
	}

	public function updatestatus($id,$status,$userid){
		$sql ="UPDATE user_permisions SET permited = :permited WHERE id=:id AND user_id = :userid";
		$save=$this->pdo->prepare($sql);
		$save->bindValue(':permited',$status);
		$save->bindValue(':userid',$userid);
		$save->bindValue(':id',	$id);
		$final  =$save->execute();
		if($final){
			return true;
		}else return false;

	}
	public function rolestatusupdate($id,$status){
		$sql ="UPDATE role SET status = :status WHERE id=:id";
		$save=$this->pdo->prepare($sql);
		$save->bindValue(':status',$status);
		$save->bindValue(':id',	$id);
		$final  =$save->execute();
		if($final){
			return true;
		}else return false;		
	}
	public function superstatusupdate($id,$status){
		$sql ="UPDATE role SET superuser = :status WHERE id=:id";
		$save=$this->pdo->prepare($sql);
		$save->bindValue(':status',$status);
		$save->bindValue(':id',	$id);
		$final  =$save->execute();
		if($final){
			return true;
		}else return false;		
	}

	public function ifhavesuperuser($id,$user){

		$sql	="SELECT count(*) FROM role WHERE superuser ='t' ";
		$sql 	= $this->pdo->query($sql);
		$count = $sql->fetch($this->obj);

		if($count->count > 0 ){
			return true;
		}else{
			return false;
		}
	}

	public function deleteuserpermisions($id,$userid){
		$sql ="DELETE FROM  user_permisions  WHERE id=:id AND user_id = :userid";
		$save=$this->pdo->prepare($sql);
		$save->bindValue(':userid',$userid);
		$save->bindValue(':id',	$id);
		$final  =$save->execute();
		if($final){
			return true;
		}else return false;

	}

	public function adduserpermissions($id,$userid,$roleid){
		$sql ="INSERT INTO user_permisions (permision_id,user_id,role_id) VALUES(:permisionid,:userid,:roleid)";
		$save=$this->pdo->prepare($sql);
		$save->bindValue(':permisionid',$id);
		$save->bindValue(':userid',	$userid);
		$save->bindValue(':roleid',	$roleid);
		$final  =$save->execute();
		if($final){
			return true;
		}else return false;

	}
    public function ifuserpermision($id,$user){
		$sql	="SELECT * FROM user_permisions WHERE permision_id =$id AND user_id = $user";
		$sql 	= $this->pdo->query($sql);
		while ($row = $sql->fetch($this->obj)) {
			$permisions=$row;
		}
		if(!empty($permisions)){
			return true;
		}else{
			return false;
		}
	}
//role mermisssions
	public function permissionsrole($id){
		$sql = $this->raw("SELECT p.*,rp.permited,rp.role_id AS roleid  FROM  permisions AS p left JOIN role_permisions AS rp ON (rp.permision_id = p.id AND rp.role_id = $id) ");
		while ($row = $sql->fetch($this->obj)) {
			$perms[]=$row;
		}

		return $perms;
	}
	public function role_permisions($id){
		$sql = $this->raw("SELECT rp.*,p.controller,p.method,p.param1 FROM  role_permisions AS rp INNER JOIN permisions AS p ON (rp.permision_id = p.id) WHERE role_id = $id");
		while ($row = $sql->fetch($this->obj)) {
			$userperms[]=$row;
		}

		return $userperms;
	}

	public function updatestatusrole($id,$status,$roleid){
		$sql ="UPDATE role_permisions SET permited = :permited WHERE id=:id AND role_id = :roleid";
		$save=$this->pdo->prepare($sql);
		$save->bindValue(':permited',$status);
		$save->bindValue(':roleid',$roleid);
		$save->bindValue(':id',	$id);
		$final  =$save->execute();
		if($final){
			return true;
		}else return false;

	}

	public function deleterolepermisions($id,$roleid){
		$sql ="DELETE FROM  role_permisions  WHERE id=:id AND role_id = :roleid";
		$save=$this->pdo->prepare($sql);
		$save->bindValue(':roleid',$roleid);
		$save->bindValue(':id',	$id);
		$final  =$save->execute();
		if($final){
			return true;
		}else return false;

	}

	public function addrolepermissions($id,$roleid){
		$sql ="INSERT INTO role_permisions (permision_id,role_id) VALUES(:permisionid,:roleid)";
		$save=$this->pdo->prepare($sql);
		$save->bindValue(':permisionid',$id);
		$save->bindValue(':roleid',	$roleid);
		$final  =$save->execute();
		if($final){
			return true;
		}else return false;

	}
    public function ifrolepermision($id,$role){
		$sql	="SELECT * FROM role_permisions WHERE permision_id =$id AND role_id = $role";
		$sql 	= $this->pdo->query($sql);
		while ($row = $sql->fetch($this->obj)) {
			$permisions=$row;
		}
		if(!empty($permisions)){
			return true;
		}else{
			return false;
		}
	}
    // for deleting permissions ****************************************
	public function ifhavethispermission($id,$table_has,$type=false){
		if($type){
			$sql ="DELETE FROM  $table_has  WHERE permision_id = :id";
			$save=$this->pdo->prepare($sql);
			$save->bindValue(':id',	$id);
			$final  =$save->execute();
			if($final){
				return true;
			}else return false;
		}else{
			$sql	="SELECT * FROM  $table_has  WHERE permision_id =$id";
			$sql 	= $this->pdo->query($sql);

			while ($row = $sql->fetch($this->obj)) {
				$permisions=$row;
			}

			if(!empty($permisions)){
				return true;
			}else{
				return false;
			}
		}
	}
	// for deleting permissions ***********************************************************

    public function visits(){ //visits
		$sql = $this->raw("SELECT * FROM visits  ORDER BY id");
		while ($row = $sql->fetch($this->obj)) {$visits[]=$row;}return $visits;
	}
	public function updateip($id,$state){
		$sql ="UPDATE visits SET state = :state WHERE id=:id";
		$save=$this->pdo->prepare($sql);
		$save->bindValue(':state',$state);
		$save->bindValue(':id',$id);
		$final  =$save->execute();
		if($final){
			return true;
		}else return false;

	}
}

