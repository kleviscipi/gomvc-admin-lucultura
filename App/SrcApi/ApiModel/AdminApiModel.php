<?php
namespace Go;

use Go\ApiModel as ApiModel;

/**
* klevis cipi
*/
class AdminApiModel extends ApiModel
{	
	private $table_movie 	= 'movies';
	private $table_actors 	= 'actors';
	private $table_media 	= 'actormedia';
	private $table_company 	= 'moviecompanies';
	private $table_book 	= 'books';
	private $table_authors 	= 'author_books';
	private $table_natyres 	= 'natyres';
	private $table_videos 	= 'videonatyres';
	private $table_cron 	= 'cronjobs';
	private $table_users 	= 'users';
	private $table_access 	= 'access';
	private $table_roles 	= 'role';
	public function persons(){

		$sql = $this->raw("SELECT * FROM persons");
		$persons=[];

		while ($row = $sql->fetch($this->obj)) {
			$persons[]=$row;
		}

		return $persons;
	}
	public function addadmin($post){
		$sql ="INSERT INTO users(name,subname,email,username,password,role_id) VALUES(:name,:subname,:email,:username,:password,:role_id)";
		$save=$this->pdo->prepare($sql);
		$save->bindValue(':name',	$post['name']);
		$save->bindValue(':subname',	$post['subname']);
		$save->bindValue(':email',	$post['email']);
		$save->bindValue(':username',	$post['username']);
		$save->bindValue(':password',	$post['password']);
		$save->bindValue(':role_id',	$post['role_id']);
		$final  =$save->execute();
		if($final){
			return true;
		}else return false;

	}
	public function thisuser($post){
		$email=$post['email'];
		$username = $post['username'];
		$sql="SELECT count(*) FROM users WHERE lower(email) = lower('$email') OR lower(username) = lower('$username')";
		$sql= $this->pdo->query($sql);

		if($sql->fetch()[0] > 0){
			return true;
		}else{
			return false;
		}

	}

	public function thisuserupdate($id,$email,$username){

		$sql="SELECT id,email,username FROM users WHERE id IN (SELECT id FROM  users WHERE id !=$id) AND ( lower(username) =lower('$username') OR lower(email) =lower('$email') )";
		$sql= $this->pdo->query($sql);

		if($sql->fetch()[0] > 0){
			return true;
		}else{
			return false;
		}

	}
	public function login($email){

		$sql	="SELECT u.*,r.superuser FROM users AS u INNER JOIN role AS r ON(u.role_id=r.id) WHERE lower(u.email) = lower('$email') OR lower(u.username) = lower('$email')";
		$sql 	= $this->pdo->query($sql);
		while ($row = $sql->fetch($this->obj)) {
			$email=$row;
		}
		return $email;

	}
	public function passwordcheck($id){

		$sql	="SELECT * FROM users where id = $id ";
		$sql 	= $this->pdo->query($sql);
		while ($row = $sql->fetch($this->obj)) {
			$user=$row;
		}
		return $user;

	}

	public function userforprofile($id){

		$sql	="SELECT * FROM users WHERE id = $id ";
		$sql 	= $this->pdo->query($sql);
		while ($row = $sql->fetch($this->obj)) {
			$user=$row;
		}
		return $user;

	}
	public function getusers(){
		$sql	="SELECT u.*,r.name AS rolename FROM users as u INNER JOIN role AS r ON(u.role_id = r.id) ORDER BY u.id DESC";
		$sql 	= $this->pdo->query($sql);
		while ($row = $sql->fetch($this->obj)) {
			$users[]=$row;
		}

		return $users;

	}
	public function deleteuser($id){
		$sql = "DELETE FROM users WHERE id = $id";
		$sql = $this->pdo->prepare($sql);
		$delete = $sql->execute();
		if($delete){
			return true;
		}else return false;
	}

	public function setrole($id,$val){
		$sql ="UPDATE users SET role_id = :role WHERE id=:id";
		$save=$this->pdo->prepare($sql);
		$save->bindValue(':role',$val);
		$save->bindValue(':id',	$id);
		$final  =$save->execute();
		if($final){
			if($this->setrole_userpermision($id,$val)){
				return true;
			}

		}else return false;

	}

	public function savepassword($id,$newpass){
		$sql ="UPDATE users SET password = :password WHERE id=:id";
		$save=$this->pdo->prepare($sql);
		$save->bindValue(':password',$newpass);
		$save->bindValue(':id',	$id);
		$final  =$save->execute();
		if($final){
		 return true;
		}else return false;

	}
	public function updateadmin($id,$name,$subname,$username,$email){
		$sql ="UPDATE users SET name = :name,subname = :subname,email = :email,username = :username WHERE id=:id";
		$save=$this->pdo->prepare($sql);
		$save->bindValue(':name',$name);
		$save->bindValue(':id',	$id);
		$save->bindValue(':username',$username);
		$save->bindValue(':email',$email);
		$save->bindValue(':subname',$subname);
		$final  =$save->execute();
		if($final){
		 return true;
		}else return false;

	}
    public function setrole_userpermision($id,$val){
		$sql ="UPDATE user_permisions SET role_id = :role WHERE user_id=:id";
		$save=$this->pdo->prepare($sql);
		$save->bindValue(':role',$val);
		$save->bindValue(':id',	$id);
		$final  =$save->execute();
		if($final){
			return true;
		}else return false;

	}
	public function updateuser($post){
		$sql ="UPDATE users SET name = :name, subname=:subname,email = :email,username=:username WHERE id=:id";
		$save=$this->pdo->prepare($sql);
		$save->bindValue(':id',$post['id']);
		$save->bindValue(':name',$post['name']);
		$save->bindValue(':subname',	$post['subname']);
		$save->bindValue(':email',	$post['email']);
		$save->bindValue(':username',	$post['username']);
		$final  =$save->execute();
		if($final){
			return true;
		}else return false;

	}
	// notifications from table actions;
	public function notifications(){
		$sql	="SELECT count(*) FROM actions WHERE forsuperuser = 't' AND status = 'f'";
		$sql 	= $this->pdo->query($sql);
		$count = $sql->fetch($this->obj);
		return $count->count;		
	}
	public function updatenotice($set){
		$sql ="UPDATE actions SET status = :sets";
		$save=$this->pdo->prepare($sql);
		$save->bindValue(':sets',$set);
		$final  =$save->execute();
		if($final){
			return true;
		}else return false;
	}
	public function notificationlist(){
		$sql	="SELECT a.*,u.name,u.subname FROM actions AS a INNER JOIN users as u on(a.user_id = u.id)";
		$sql 	= $this->pdo->query($sql);
		while ($row = $sql->fetch($this->obj)) {
			$notice[]=$row;
		}

		return $notice;		
	}
	public function notificationday($date){
		$sql	="SELECT a.*,u.name,u.subname FROM actions AS a inner join users as u on(a.user_id = u.id) WHERE CAST (a.created AS DATE) = '$date'";
		$sql 	= $this->pdo->query($sql);
		while ($row = $sql->fetch($this->obj)) {
			$n[]=$row;
		}
		return $n;		
	}
	public function cronjobs(){
		$sql	="SELECT *, CAST (created AS DATE ) FROM $this->table_cron ORDER BY id DESC  LIMIT 4";
		$sql 	= $this->pdo->query($sql);
		while ($row = $sql->fetch($this->obj)) {
			$cron[]=$row;
		}

		return $cron;		
	}

	public function access(){
		$sql	="SELECT *, CAST (created AS DATE ) FROM $this->table_access ORDER BY id DESC  LIMIT 4";
		$sql 	= $this->pdo->query($sql);
		while ($row = $sql->fetch($this->obj)) {
			$access[]=$row;
		}

		return $access;		
	}
	public function actions(){
		$sql	="SELECT a.*,u.name,u.subname FROM actions AS a INNER JOIN users as u on(a.user_id = u.id) LIMIT 4";
		$sql 	= $this->pdo->query($sql);
		while ($row = $sql->fetch($this->obj)) {
			$notice[]=$row;
		}

		return $notice;		
	}
	//******************* statistics*******************//

	public function statistics(){
		$sqlmovies = $this->raw("SELECT count(*) FROM $this->table_movie");
			$list['movies']=$sqlmovies->fetch($this->obj);
		$sqlactors = $this->raw("SELECT count(*) FROM $this->table_actors");
			$list['actors']=$sqlactors->fetch($this->obj);
		$sqlcom = $this->raw("SELECT count(*) FROM $this->table_company");
			$list['company']=$sqlcom->fetch($this->obj);
		$sqlmovies_withactor = $this->raw("SELECT count(*) FROM $this->table_movie AS m INNER JOIN $this->table_actors as a ON(m.idm_actor = a.idm_id)");
			$list['moviewithactor']=$sqlmovies_withactor->fetch($this->obj);
			
		$sqlbooks = $this->raw("SELECT count(*) FROM $this->table_book");
			$list['books']=$sqlbooks->fetch($this->obj);

		$sqlauthors = $this->raw("SELECT count(*) FROM $this->table_authors");
			$list['authors']=$sqlauthors->fetch($this->obj);

		$sqlempty = $this->raw("SELECT count(*) FROM $this->table_book WHERE author_name IS NULL AND author_id IS NULL ");
			$list['bookemptyauthor']=$sqlempty->fetch($this->obj);
		$natyres = $this->raw("SELECT count(*) FROM $this->table_natyres");
			$list['natyres']=$natyres->fetch($this->obj);
		$videos = $this->raw("SELECT count(*) FROM $this->table_videos");
			$list['videos']=$videos->fetch($this->obj);
		$cron = $this->raw("SELECT count(*) FROM $this->table_cron");
			$list['cronjobs']=$cron->fetch($this->obj);
		$users = $this->raw("SELECT count(*) FROM $this->table_users");
			$list['users']=$users->fetch($this->obj);
		$roles = $this->raw("SELECT count(*) FROM $this->table_roles");
			$list['roles']=$roles->fetch($this->obj);		
		return (object)$list;
	}

	/*************************Search***************************************/
	public function search($words){
	   	$word = strtolower(trim($words));
	   	$actors = $this->raw("SELECT * FROM $this->table_actors WHERE lower(name) like '%$word%' limit 5");
		while ($row = $actors->fetch($this->obj)) { $list['actors'][]=$row; }
		$movies = $this->raw("SELECT * FROM $this->table_movie WHERE lower(title) like '%$word%' limit 5");
	  	while ($row = $movies->fetch($this->obj)) { $list['movies'][]=$row; }

	  	$books = $this->raw("SELECT * FROM $this->table_book WHERE lower(title) like '%$word%'  limit 5");
	  	while ($row = $books->fetch($this->obj)) { $list['books'][]=$row; }

	    $authors = $this->raw("SELECT * FROM $this->table_authors WHERE lower(fullname) like '%$word%' limit 5");
	  	while ($row = $authors->fetch($this->obj)) { $list['authors'][]=$row; }

	    $pages = $this->raw("SELECT * FROM permisions WHERE lower(method) like '%$word%' limit 5");
	  	while ($row = $pages->fetch($this->obj)) { $list['pages'][]=$row; }

	  	return $list;
	}

}