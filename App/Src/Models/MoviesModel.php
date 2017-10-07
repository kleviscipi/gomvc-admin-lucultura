<?php
namespace Go;
use Go\Connection as Connection;
use Go\AppModel as AppModel;

/***********************************
* 2016-11-16                       *
* Klevis Cipi                      * 
* cipiklevis@gmail.com             * 
*                                  * 
***********************************/

class MoviesModel extends AppModel
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
	public function actors(){

	   $sql = $this->raw("SELECT * FROM $this->table_actors");
		while ($row = $sql->fetch($this->obj)) {
			$list[]=$row;
		}
		return $list;
	}
	public function movie($id){

	   $sql = $this->raw("SELECT m.*,t.link as trailerlink,i.pathimg as headerimg FROM $this->table as m LEFT JOIN trailers as t on(m.idm_id = t.idm_movie) LEFT JOIN imgheadermovie AS i on(i.id_movie = m.id) WHERE m.id = $id");
		while ($row = $sql->fetch($this->obj)) {
			$list=$row;
		}
		return $list;
	}

	public function actor($id){

	   $sql = $this->raw("SELECT * FROM $this->table_actors WHERE lower(idm_id) = lower('$id') OR name like '%$id%'");
		while ($row = $sql->fetch($this->obj)) {
			$list[]=$row;
		}
		return $list;
	}

	public function actor_movies($id){

	   $sql = $this->raw("SELECT a.*,m.*,a.idm_id as actor_idm,m.idm_id as movie_idm FROM $this->table_actors AS a INNER JOIN $this->table as m ON(a.idm_id = m.idm_actor) WHERE lower(a.idm_id) = lower('$id') OR  lower(a.name) = lower('$id')");
		while ($row = $sql->fetch($this->obj)) {
			$list[]=$row;
		}
		return $list;
	}
	public function add($post){

		$sql ="INSERT INTO $this->table (id,idm_id,idm_actor,info,title,year,description,casts,direction,duration,genres,image,created,modified) VALUES(id,:idm_id,:idm_actor,:info,:title,:year,:description,:casts,:direction,:duration,:genres,:image,:created,:modified)";

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
	public function delete($id){
		$sql = "DELETE FROM $this->table WHERE id = $id";
		$sql = $this->pdo->prepare($sql);
		$delete = $sql->execute();
		if($delete){
			return true;
		}else return false;
	}

	public function update($id,$post){
	
	$sql ="UPDATE $this->table SETidm_id = :idm_id,idm_actor = :idm_actor,info = :info,title = :title,year = :year,description = :description,casts = :casts,direction = :direction,duration = :duration,genres = :genres,image = :image,created = :created,modified = :modified  WHERE id=:id";	
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
	public function statistics(){
		$sqlmovies = $this->raw("SELECT count(*) FROM $this->table");
			$list['movies']=$sqlmovies->fetch($this->obj);
		$sqlactors = $this->raw("SELECT count(*) FROM $this->table_actors");
			$list['actors']=$sqlactors->fetch($this->obj);
		$sqlcom = $this->raw("SELECT count(*) FROM $this->table_company");
			$list['company']=$sqlcom->fetch($this->obj);
		$sqlmovies_withactor = $this->raw("SELECT count(*) FROM $this->table AS m INNER JOIN $this->table_actors as a ON(m.idm_actor = a.idm_id)");
			$list['moviewithactor']=$sqlmovies_withactor->fetch($this->obj);

	
		return (object)$list;
	}

	public function ifimageexist($id){
		$sql	="SELECT * FROM imgheadermovie WHERE id_movie = $id ";
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
	public function insertimgheader($id,$val){
		$sql ="INSERT INTO imgheadermovie (id_movie,pathimg) VALUES(:id_movie,:pathimg)";
		$save=$this->pdo->prepare($sql);
		$save->bindValue(':id_movie',$id);
		
		$save->bindValue(':pathimg',$val);
			
		$final  =$save->execute();
		if($final){
			return true;
		}else return false;
	}
	public function updateimgheader($id,$val){
	
	$sql ="UPDATE imgheadermovie SET pathimg = :link  WHERE id_movie=:id";	
		$save=$this->pdo->prepare($sql);
	
		$save->bindValue(':id',$id);
		
		$save->bindValue(':link',$val);
		
		$final  =$save->execute();

		if($final){
			return true;
		}else return false;		
	}

}