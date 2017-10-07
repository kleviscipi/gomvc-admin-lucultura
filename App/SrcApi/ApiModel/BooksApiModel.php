<?php
namespace Go;
use Go\ApiModel as ApiModel;

/***********************************
* 2016-11-17                       *
* Klevis Cipi                      * 
* cipiklevis@gmail.com             * 
*                                  * 
***********************************/

class BooksApiModel extends ApiModel
{	
	private $table = 'books';
	private $table_author = 'author_books';
	public function books(){

	   $sql = $this->raw("SELECT * FROM $this->table");
		while ($row = $sql->fetch($this->obj)) {
			$list[]=$row;
		}
		return $list;
	}

	public function book($id){

	   $sql = $this->raw("SELECT * FROM $this->table WHERE id = $id");
		while ($row = $sql->fetch($this->obj)) {
			$list[]=$row;
		}
		return $list;
	}

	public function add($post){

		$sql ="INSERT INTO $this->table (google_id,json_volume,previewlink,title,author_id,author_name,publisher,publisherdate,description,categories,pages,rating,language,image) VALUES(:google_id,:json_volume,:previewlink,:title,:author_id,:author_name,:publisher,:publisherdate,:description,:categories,:pages,:rating,:language,:image)";

		$save=$this->pdo->prepare($sql);

		$save->bindValue(':google_id',$post['google_id']);
		
		$save->bindValue(':json_volume',$post['json_volume']);
		
		$save->bindValue(':previewlink',$post['previewlink']);
		
		$save->bindValue(':title',$post['title']);
		
		$save->bindValue(':author_id',$post['author_id']);
		
		$save->bindValue(':author_name',$post['author_name']);
		
		$save->bindValue(':publisher',$post['publisher']);
		
		$save->bindValue(':publisherdate',$post['publisherdate']);
		
		$save->bindValue(':description',$post['description']);

		$save->bindValue(':categories','{'.implode(',',$post['categories']).'}');

		$save->bindValue(':pages',$post['pages']);
		
		$save->bindValue(':rating',$post['rating']);
		
		$save->bindValue(':language',$post['language']);

		$save->bindValue(':image',$post['image']);
			
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
	public function delete_books($id){
		$sql = "DELETE FROM $this->table WHERE author_id = $id";
		$sql = $this->pdo->prepare($sql);
		$delete = $sql->execute();
		if($delete){
			return true;
		}else return false;
	}
	public function deleteauthor($id){
		$sql = "DELETE FROM $this->author_books WHERE id = $id";
		$sql = $this->pdo->prepare($sql);
		$delete = $sql->execute();
		if($delete){
			return true;
		}else return false;
	}
	public function update($id,$post){
	
	$sql ="UPDATE $this->table SET googl_id = :googl_id,
		json_volume 	= :json_volume,
		previelink 		= :previelink,
		title 			= :title,
		author_id 		= :author_id,
		author_name 	= :author_name,
		publisher 		= :publisher,
		publisherdate 	= :publisherdate,
		description 	= :description,
		categories 		= :categories,
		pages 			= :pages,
		rating 			= :rating,
		language 		= :language  WHERE id=:id";	

		$save=$this->pdo->prepare($sql);
	
		$save->bindValue(':google_id',strtolower($post['google_id']));
		
		$save->bindValue(':json_volume',strtolower($post['json_volume']));
		
		$save->bindValue(':previelink',strtolower($post['previelink']));
		
		$save->bindValue(':title',strtolower($post['title']));
		
		$save->bindValue(':author_id',strtolower($post['author_id']));
		
		$save->bindValue(':author_name',strtolower($post['author_name']));
		
		$save->bindValue(':publisher',strtolower($post['publisher']));
		
		$save->bindValue(':publisherdate',strtolower($post['publisherdate']));
		
		$save->bindValue(':description',strtolower($post['description']));
		
		$save->bindValue(':categories',strtolower($post['categories']));
		
		$save->bindValue(':pages',strtolower($post['pages']));
		
		$save->bindValue(':rating',strtolower($post['rating']));
		
		$save->bindValue(':language',strtolower($post['language']));
		
		$final  =$save->execute();

		if($final){
			return true;
		}else return false;		
	}
	public function ifbook($id){
		$sql	="SELECT * FROM $this->table WHERE lower(google_id) =lower('$id')";
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
	public function ifauthor($name){
		$sql	="SELECT * FROM $this->table_author WHERE lower(fullname) =lower('$name')";
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

	public function addauthor($fullname){
		$sql ="INSERT INTO $this->table_author (fullname) VALUES(:fullname)";

		$save=$this->pdo->prepare($sql);

		$save->bindValue(':fullname',$fullname);
			
		$final  =$save->execute();
		if($final){
			return true;
		}else return false;
	}

	public function author($name=''){
		$sql = $this->raw("SELECT * FROM $this->table_author WHERE lower(fullname) = lower('$name') ");
		while ($row = $sql->fetch($this->obj)) {
			$author[]=$row;
		}
		return $author;
	}
}