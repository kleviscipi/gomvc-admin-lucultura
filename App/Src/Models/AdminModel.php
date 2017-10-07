<?php

namespace Go;
use Go\Connection as Connection;
use Go\AppModel as AppModel;

/**
* klevis cipi
*/
class AdminModel extends AppModel
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
	private $limit;

	public function csv_db(){

	    $tables = $this->schema()->schema;

	    foreach ($tables as $key => $table) {
			$copy_csv = "COPY (select * from $table->table_name) TO '/home/onlinedev10/myproject/gitlab/admin-lucultura/App/Core/_data/backup/".$table->table_name.".csv' DELIMITER ';' CSV HEADER;";    	
			$this->pdo->exec($copy_csv);
	    }

		if($copy_csv){
			return true;	
		}else{
			return false;		
		} 

	}
	public function import_csv_db(){
	    $tables = $this->schema()->schema;

	    foreach ($tables as $key => $table) {
			$copy_csv = "COPY $table->table_name FROM '/home/onlinedev10/myproject/gitlab/admin-lucultura/App/Core/_data/backup/".$table->table_name.".csv' DELIMITER ';' CSV HEADER;";    	
			$this->pdo->exec($copy_csv);
	    }

		if($copy_csv){
			return true;	
		}else{
			return false;		
		} 		
	}

	public function dropdb(){
	    $tables = $this->schema()->schema;
	    $i = 0;
	    foreach ($tables as $key => $table) {
			$drop = "DROP TABLE $table->table_name";    	
			$this->pdo->exec($drop);
			if($drop){
				$i++;
			}
	    }
		if($i > 0){
			return true;	
		}else{
			return false;		
		} 		
	}
	public function deletedb(){
	    $tables = $this->schema()->schema;
	    $i = 0;
	    foreach ($tables as $key => $table) {
			$drop = "DELETE FROM TABLE $table->table_name";    	
			$this->pdo->exec($drop);
			if($drop){
				$i++;
			}
	    }
		if($i > 0){
			return true;	
		}else{
			return false;		
		} 		
	}
	public function droptable($table){
		$drop = "DROP TABLE $table";    	
		$save = $this->pdo->exec($drop);
		if($drop){
			return true;	
		}else{
			return false;		
		} 		
	}
	public function deletetable($table){
		$drop = "DELETE FROM $table";    	
		$save = $this->pdo->exec($drop);
		if($drop){
			return true;	
		}else{
			return false;		
		} 		
	}
	public function searchs($limit,$words){
		$this->limit = $limit;
	   	$word = strtolower(trim($words));
	   	$actors = $this->raw("SELECT * ,( SELECT count(id) FROM $this->table_actors WHERE lower(name) like '%$word%') AS total FROM $this->table_actors WHERE lower(name) like '%$word%' $this->limit");
		while ($row = $actors->fetch($this->obj)) { $list['actors'][]=$row; }
		$movies = $this->raw("SELECT * ,( SELECT count(id) FROM $this->table_movie WHERE lower(title) like '%$word%') AS total FROM $this->table_movie WHERE lower(title) like '%$word%' $this->limit");
	  	while ($row = $movies->fetch($this->obj)) { $list['movies'][]=$row; }

	  	$books = $this->raw("SELECT * ,( SELECT count(id) FROM $this->table_book WHERE lower(title) like '%$word%') AS total FROM $this->table_book WHERE lower(title) like '%$word%'  $this->limit");
	  	while ($row = $books->fetch($this->obj)) { $list['books'][]=$row; }

	    $authors = $this->raw("SELECT * ,( SELECT count(id) FROM $this->table_authors WHERE lower(fullname) like '%$word%') AS total FROM $this->table_authors WHERE lower(fullname) like '%$word%' $this->limit");
	  	while ($row = $authors->fetch($this->obj)) { $list['authors'][]=$row; }

	    $natyres = $this->raw("SELECT * ,( SELECT count(id) FROM $this->table_natyres WHERE lower(tags) like '%$word%') AS total FROM $this->table_natyres WHERE lower(tags) like '%$word%' $this->limit");
	  	while ($row = $natyres->fetch($this->obj)) { $list['natyres'][]=$row; }

	    $videos = $this->raw("SELECT * ,( SELECT count(id) FROM $this->table_videos WHERE lower(tags) like '%$word%') AS total FROM $this->table_videos WHERE lower(tags) like '%$word%' $this->limit");
	  	while ($row = $videos->fetch($this->obj)) { $list['videos'][]=$row; }

	  	return $list;
	}

	public function user($id,$email){

	   $sql = $this->raw("SELECT u.*,r.name as rolename FROM users as u  INNER JOIN role as r ON(u.role_id = r.id) WHERE lower(u.email) = lower('$email') AND u.id = $id ");
		while ($row = $sql->fetch($this->obj)) {
			$user=$row;
		}
		return $user;
	}
	public function userfromlist($id){

	   $sql = $this->raw("SELECT u.*,r.name as rolename FROM users as u  INNER JOIN role as r ON(u.role_id = r.id) WHERE  u.id = $id ");
		while ($row = $sql->fetch($this->obj)) {
			$user=$row;
		}
		return $user;
	}
	public function ifuserexist($id){
		$user = $this->raw("SELECT count(*) FROM users WHERE id = $id");
	  	while ($row = $user->fetch($this->obj)) { $list['user']=$row; } return $list;
	}
	public function visits($ip,$broswer){
		$sql ="INSERT INTO visits(ip,broswer,state) VALUES(:ip,:broswer,:state)";
		$save=$this->pdo->prepare($sql);
		$save->bindValue(':ip',$ip);
		$save->bindValue(':broswer',$broswer);
		$save->bindValue(':state',	'true');
		$final  =$save->execute();
		if($final){
			return true;
		}else return false;

	}
    public function ifip($ip){
		$ip = $this->raw("SELECT count(*) FROM visits WHERE lower(ip) = lower('$ip')");
	  	while ($row = $ip->fetch($this->obj)) { $list['ifip']=$row; } return $list;
	}

}