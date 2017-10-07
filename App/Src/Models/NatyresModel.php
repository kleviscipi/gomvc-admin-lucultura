<?php
namespace Go;
use Go\Connection as Connection;
use Go\AppModel as AppModel;

/***********************************
* 2016-11-18                       *
* Klevis Cipi                      * 
* cipiklevis@gmail.com             * 
*                                  * 
***********************************/

class NatyresModel extends AppModel
{	
	private $table = 'natyres';
	private $table_videos = 'videonatyres';
	private $limit;

	public function natyres($limit){
		$this->limit = $limit;
	   $sql = $this->raw("SELECT * ,( SELECT count(id) FROM $this->table ) AS total FROM $this->table   $this->limit");
		while ($row = $sql->fetch($this->obj)) {
			$list[]=$row; 
		}
		return $list;
	}
	public function natyre($id){

	   $sql = $this->raw("SELECT * FROM $this->table WHERE id = $id");
		while ($row = $sql->fetch($this->obj)) {
			$list[]=$row;
		}
		return $list;
	}
	public function video($id){

	   $sql = $this->raw("SELECT * FROM $this->table_videos WHERE id = $id");
		while ($row = $sql->fetch($this->obj)) {
			$list[]=$row;
		}
		return $list;
	}
	public function videos($id){

	   $sql = $this->raw("SELECT * FROM $this->table_videos");
		while ($row = $sql->fetch($this->obj)) {
			$list[]=$row;
		}
		return $list;
	}
	public function add($post){

		$sql ="INSERT INTO $this->table (web_id,webwidth,webheight,downloads,pageurl,weburl,tags,created,modified) VALUES(:web_id,:webwidth,:webheight,:downloads,:pageurl,:weburl,:tags)";

		$save=$this->pdo->prepare($sql);
		$save->bindValue(':web_id',strtolower($post['web_id']));
		
		$save->bindValue(':webwidth',strtolower($post['webwidth']));
		
		$save->bindValue(':webheight',strtolower($post['webheight']));
		
		$save->bindValue(':downloads',strtolower($post['downloads']));
		
		$save->bindValue(':pageurl',strtolower($post['pageurl']));
		
		$save->bindValue(':weburl',strtolower($post['weburl']));
		
		$save->bindValue(':tags',strtolower($post['tags']));
		
			
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
	
	$sql ="UPDATE $this->table SETweb_id = :web_id,webwidth = :webwidth,webheight = :webheight,downloads = :downloads,pageurl = :pageurl,weburl = :weburl,tags = :tags,created = :created,modified = :modified  WHERE id=:id";	
		$save=$this->pdo->prepare($sql);
	
		$save->bindValue(':web_id',strtolower($post['web_id']));
		
		$save->bindValue(':webwidth',strtolower($post['webwidth']));
		
		$save->bindValue(':webheight',strtolower($post['webheight']));
		
		$save->bindValue(':downloads',strtolower($post['downloads']));
		
		$save->bindValue(':pageurl',strtolower($post['pageurl']));
		
		$save->bindValue(':weburl',strtolower($post['weburl']));
		
		$save->bindValue(':tags',strtolower($post['tags']));
		
		$save->bindValue(':created',strtolower($post['created']));
		
		$save->bindValue(':modified',strtolower($post['modified']));
		
		$final  =$save->execute();

		if($final){
			return true;
		}else return false;		
	}

}