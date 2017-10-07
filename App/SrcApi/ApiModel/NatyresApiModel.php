<?php
namespace Go;
use Go\ApiModel as ApiModel;

/***********************************
* 2016-11-18                       *
* Klevis Cipi                      * 
* cipiklevis@gmail.com             * 
*                                  * 
***********************************/

class NatyresApiModel extends ApiModel
{	
	public $table = 'natyres';
	public $table_video ='videonatyres';

	public function natyres(){

	   $sql = $this->raw("SELECT * FROM $this->table");
		while ($row = $sql->fetch($this->obj)) {
			$list[]=$row;
		}
		return $list;
	}
	public function videos(){

	   $sql = $this->raw("SELECT * FROM $this->table_video");
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

	public function add($post){

		$sql ="INSERT INTO $this->table (web_id,webwidth,webheight,pageurl,weburl,tags) VALUES(:web_id,:webwidth,:webheight,:pageurl,:weburl,:tags)";

		$save=$this->pdo->prepare($sql);
		$save->bindValue(':web_id',$post['web_id']);
		
		$save->bindValue(':webwidth',$post['webwidth']);
		
		$save->bindValue(':webheight',$post['webheight']);
	
		$save->bindValue(':pageurl',$post['pageurl']);
		
		$save->bindValue(':weburl',$post['weburl']);
		
		$save->bindValue(':tags',$post['tags']);
			
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
	public function deletevideo($id){
		$sql = "DELETE FROM $this->table_videos WHERE id = $id";
		$sql = $this->pdo->prepare($sql);
		$delete = $sql->execute();
		if($delete){
			return true;
		}else return false;
	}
	public function update($id,$post){
	
	$sql ="UPDATE $this->table SET web_id = :web_id,webwidth = :webwidth,webheight = :webheight,pageurl = :pageurl,weburl = :weburl,tags = :tags,modified = now()  WHERE id=:id";	
		$save=$this->pdo->prepare($sql);
		$save->bindValue(':id',$id);

		$save->bindValue(':web_id',$post['web_id']);
		
		$save->bindValue(':webwidth',$post['webwidth']);
		
		$save->bindValue(':webheight',$post['webheight']);
		
		$save->bindValue(':pageurl',$post['pageurl']);
		
		$save->bindValue(':weburl',$post['weburl']);
		
		$save->bindValue(':tags',$post['tags']);
			
		
		$final  =$save->execute();

		if($final){
			return true;
		}else return false;		
	}

	public function addvideo($post){

		$sql ="INSERT INTO $this->table_video (web_id,picture_id,webwidth,webheight,size,pageurl,weburl,tags,duration) VALUES(:web_id,:picture_id,:webwidth,:webheight,:size,:pageurl,:weburl,:tags,:duration)";

		$save=$this->pdo->prepare($sql);
		$save->bindValue(':web_id',$post['web_id']);
		
		$save->bindValue(':picture_id',$post['picture_id']);

		$save->bindValue(':webwidth',$post['webwidth']);
		
		$save->bindValue(':webheight',$post['webheight']);

		$save->bindValue(':size',$post['size']);
		
		$save->bindValue(':pageurl',$post['pageurl']);
		
		$save->bindValue(':weburl',$post['weburl']);
		
		$save->bindValue(':tags',$post['tags']);

		$save->bindValue(':duration',$post['duration']);
			
		$final  =$save->execute();
		if($final){
			return true;
		}else return false;

	}
	public function updatevideo($id,$post){
	
	$sql ="UPDATE $this->table_video SET web_id = :web_id,picture_id=:picture_id,webwidth = :webwidth,webheight = :webheight,size=:size,pageurl = :pageurl,weburl = :weburl,duration=:duration,tags = :tags,modified = now()  WHERE id=:id";	
		$save=$this->pdo->prepare($sql);
		$save->bindValue(':id',$id);

		$save->bindValue(':web_id',$post['web_id']);
		
		$save->bindValue(':picture_id',$post['picture_id']);

		$save->bindValue(':webwidth',$post['webwidth']);
		
		$save->bindValue(':webheight',$post['webheight']);

		$save->bindValue(':size',$post['size']);
		
		$save->bindValue(':pageurl',$post['pageurl']);
		
		$save->bindValue(':weburl',$post['weburl']);
		
		$save->bindValue(':tags',$post['tags']);

		$save->bindValue(':duration',$post['duration']);
			
		
		$final  =$save->execute();

		if($final){
			return true;
		}else return false;		
	}
	public function ifexist($id){
		$sql = $this->raw("SELECT count(*) FROM $this->table_video WHERE web_id = $id");

		$count['video'] = $sql->fetch($this->obj);

		$sqlimg = $this->raw("SELECT count(*) FROM $this->table WHERE web_id = $id");

		$count['images'] = $sqlimg->fetch($this->obj);	
		return (object) $count;
	}

}