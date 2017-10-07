<?php
namespace Go;
use Go\ApiModel as ApiModel;

/***********************************
* 2016-11-16                       *
* Klevis Cipi                      * 
* cipiklevis@gmail.com             * 
*                                  * 
***********************************/

class MoviesApiModel extends ApiModel
{	
	private $table 			= 'movies';
	private $table_actors 	= 'actors';
	private $table_media 	= 'actormedia';
	private $table_company 	= 'moviecompanies';
	public function movies(){

	   $sql = $this->raw("SELECT * FROM $this->table");
		while ($row = $sql->fetch($this->obj)) {
			$list[]=$row;
		}
		return $list;
	}

	public function movie($id){

	   $sql = $this->raw("SELECT * FROM $this->table WHERE id = $id");
		while ($row = $sql->fetch($this->obj)) {
			$list[]=$row;
		}
		return $list;
	}

	public function add($post){

		$sql ="INSERT INTO $this->table (idm_id,idm_actor,info,title,year,description,casts,direction,duration,genres,image,texts,rating,released,writers) VALUES(:idm_id,:idm_actor,:info,:title,:year,:description,:casts,:direction,:duration,:genres,:image,:texts,:rating,:released,:writers)";

		$save=$this->pdo->prepare($sql);
		$save->bindValue(':idm_id',$post['idm_id']);
		
		$save->bindValue(':idm_actor',$post['idm_actor']);
		
		$save->bindValue(':info',$post['info']);
		
		$save->bindValue(':title',$post['title']);
		
		$save->bindValue(':year',$post['year']);
		
		$save->bindValue(':description',$post['description']);
		
		$save->bindValue(':casts','{'.implode(',',$post['casts']).'}');
		
		$save->bindValue(':direction','{'.implode(',',$post['direction']).'}');
		
		$save->bindValue(':duration',$post['duration']);
		
		$save->bindValue(':genres','{'.implode(',',$post['genres']).'}');
		
		$save->bindValue(':image',$post['image']);

		$save->bindValue(':texts',$post['texts']);

		$save->bindValue(':rating',$post['rating']);
		
		$save->bindValue(':released',$post['released']);

		$save->bindValue(':writers','{'.implode(',',$post['writers']).'}');

		$final  =$save->execute();
		if($final){
			return true;
		}else return false;

	}

	public function addactor($id,$name,$description,$img,$ocupation=[]){

		$sql ="INSERT INTO actors (idm_id,description,ocupation,name,image) VALUES(:idm_id,:description,:ocupation,:name,:image)";

		$save=$this->pdo->prepare($sql);
		$save->bindValue(':idm_id',$id);
	
		$save->bindValue(':description',$description);

		$save->bindValue(':ocupation','{'.implode(',',$ocupation).'}');
		
		$save->bindValue(':name',$name );
		
		$save->bindValue(':image',$img );
		
			
		$final  =$save->execute();
		if($final){
			return true;
		}else return false;

	}
	public function addactormedia($img,$idactor){

		$sql ="INSERT INTO $this->table_media (idm_id,link) VALUES(:idm_id,:link)";

		$save=$this->pdo->prepare($sql);
		$save->bindValue(':idm_id',$idactor);
		
		$save->bindValue(':link',$img);
			
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
	public function delete_movies($id){

		$sql = "DELETE FROM $this->table WHERE idm_actor = $id";
		$sql = $this->pdo->prepare($sql);
		$delete = $sql->execute();
		if($delete){
			return true;
		}else return false;
	}

	public function delete_actor($id){
		
		$sql = "DELETE FROM $this->table_actors WHERE idm_id = $id";
		$sql = $this->pdo->prepare($sql);
		$delete = $sql->execute();
		if($delete){
			return true;
		}else return false;
	}
	public function update($id,$post){
	
	$sql ="UPDATE $this->table SET idm_id = :idm_id,idm_actor = :idm_actor,info = :info,title = :title,year = :year,description = :description,casts = :casts,direction = :direction,duration = :duration,genres = :genres,image = :image,created = :created,modified = :modified,idm_id = :idm_id,idm_actor = :idm_actor,info = :info,title = :title,year = :year,description = :description,casts = :casts,direction = :direction,duration = :duration,genres = :genres,image = :image,created = :created,modified = :modified  WHERE id=:id";	
		$save=$this->pdo->prepare($sql);
	
		$save->bindValue(':idm_id',strtolower($post['idm_id']));
		
		$save->bindValue(':idm_actor',strtolower($post['idm_actor']));
		
		$save->bindValue(':info',strtolower($post['info']));
		
		$save->bindValue(':title',strtolower($post['title']));
		
		$save->bindValue(':year',strtolower($post['year']));
		
		$save->bindValue(':description',strtolower($post['description']));
		
		$save->bindValue(':casts',strtolower($post['casts']));
		
		$save->bindValue(':direction',strtolower($post['direction']));
		
		$save->bindValue(':duration',strtolower($post['duration']));
		
		$save->bindValue(':genres',strtolower($post['genres']));
		
		$save->bindValue(':image',strtolower($post['image']));
		
		$save->bindValue(':created',strtolower($post['created']));
		
		$save->bindValue(':modified',strtolower($post['modified']));
		
		$final  =$save->execute();

		if($final){
			return true;
		}else return false;		
	}

	public function ifmovie($id){
		$sql	="SELECT * FROM movies WHERE lower(idm_id) =lower('$id')";
		$sql 	= $this->pdo->query($sql);
		while ($row = $sql->fetch($this->obj)) {
			$movie=$row;
		}
		if(!empty($movie)){
			return true;
		}else{
			return false;
		}
	}
	public function ifactor($id){
		$sql	="SELECT * FROM actors WHERE lower(idm_id) =lower('$id')";
		$sql 	= $this->pdo->query($sql);
		while ($row = $sql->fetch($this->obj)) {
			$actor=$row;
		}
		if(!empty($actor)){
			return true;
		}else{
			return false;
		}
	}
	public function ifcompany($id){
		$sql	="SELECT * FROM $this->table_company WHERE lower(idm_id) =lower('$id')";
		$sql 	= $this->pdo->query($sql);
		while ($row = $sql->fetch($this->obj)) {
			$com=$row;
		}
		if(!empty($com)){
			return true;
		}else{
			return false;
		}
	}
	public function addcompay($id,$title){
		$sql ="INSERT INTO $this->table_company (idm_id,name) VALUES(:idm_id,:name)";

		$save=$this->pdo->prepare($sql);
		$save->bindValue(':idm_id',$id);
		
		$save->bindValue(':name',$title);
			
		$final  =$save->execute();
		if($final){
			return true;
		}else return false;
	}

	public function selectactor($name=''){
		$sql = $this->raw("SELECT * FROM $this->table_actors WHERE lower(name) = lower('$name') ");
		while ($row = $sql->fetch($this->obj)) {
			$actor[]=$row;
		}

		return $actor;
	}

	public function iftrailerexist($id){
		$sql	="SELECT * FROM trailers WHERE lower(idm_movie) =lower('$id')";
		$sql 	= $this->pdo->query($sql);
		while ($row = $sql->fetch($this->obj)) {
			$com=$row;
		}
		if(!empty($com)){
			return true;
		}else{
			return false;
		}
	}

	public function inserttrailer($id,$val){
		$sql ="INSERT INTO trailers (idm_movie,link) VALUES(:idm_movie,:link)";

		$save=$this->pdo->prepare($sql);
		$save->bindValue(':idm_movie',$id);
		
		$save->bindValue(':link',$val);
			
		$final  =$save->execute();
		if($final){
			return true;
		}else return false;
	}

	public function updatetrailer($id,$val){
	
	$sql ="UPDATE trailers SET link = :link  WHERE idm_movie=:id";	
		$save=$this->pdo->prepare($sql);
	
		$save->bindValue(':id',$id);
		
		$save->bindValue(':link',$val);
		
		$final  =$save->execute();

		if($final){
			return true;
		}else return false;		
	}

	public function addonsite($id,$val){
	
	$sql ="UPDATE $this->table SET onsite = :state  WHERE idm_id=:id";	
		$save=$this->pdo->prepare($sql);
	
		$save->bindValue(':id',$id);
		
		$save->bindValue(':state',$val);
		
		$final  =$save->execute();

		if($final){
			return true;
		}else return false;		
	}

	public function addonheadersite($id,$val){
	
	$sql ="UPDATE $this->table SET onheadersite = :state  WHERE idm_id=:id";	
		$save=$this->pdo->prepare($sql);
	
		$save->bindValue(':id',$id);
		
		$save->bindValue(':state',$val);
		
		$final  =$save->execute();

		if($final){
			return true;
		}else return false;		
	}
}