<?php
namespace Go;
use Go\Connection as Connection;
use Go\AppModel as AppModel;

/***********************************
* 2016-11-25                       *
* Klevis Cipi                      * 
* cipiklevis@gmail.com             * 
*                                  * 
***********************************/

class PermissionsModel extends AppModel
{	
	private $table = 'permissions';

	public function permissions(){

	   $sql = $this->raw("SELECT * FROM $this->table");
		while ($row = $sql->fetch($this->obj)) {
			$list[]=$row;
		}
		return $list;
	}
	public function permission($id){

	   $sql = $this->raw("SELECT * FROM $this->table WHERE id = $id");
		while ($row = $sql->fetch($this->obj)) {
			$list[]=$row;
		}
		return $list;
	}
	public function add($post){

		$sql ="INSERT INTO $this->table () VALUES()";

		$save=$this->pdo->prepare($sql);	
		$final  =$save->execute();
		if($final){
			return true;
		}else return false;

	}
	public function delete($id){
		$sql = "DELETE FROM $this->table WHERE id = $id";
		$sql = $this->pdo->prepare($sql);
		$delete = $sql->execute();
		if($delete){
			return true;
		}else return false;
	}

	public function update($id,$post){
	
	$sql ="UPDATE $this->table SET  WHERE id=:id";	
		$save=$this->pdo->prepare($sql);
	
		$final  =$save->execute();

		if($final){
			return true;
		}else return false;		
	}
	public function persons(){

		$sql = $this->raw("SELECT * FROM persons");
		$persons=[];

		while ($row = $sql->fetch($this->obj)) {
			$persons[]=$row;
		}

		return $persons;
	}
	public function getuser($id){

		$sql = $this->raw("SELECT u.*, r.name as rolename, CAST (u.created AS DATE)  FROM users as u INNER JOIN role as r ON(u.role_id  = r.id) WHERE u.id = $id");
		while ($row = $sql->fetch($this->obj)) {
			$user=$row;
		}

		return $user;
	}
	public function getrole($id){

		$sql = $this->raw("SELECT * FROM role WHERE id=$id");
		while ($row = $sql->fetch($this->obj)) {
			$role=$row;
		}
		return $role;
	}
}