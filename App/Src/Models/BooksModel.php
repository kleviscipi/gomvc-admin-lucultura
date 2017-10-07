<?php
namespace Go;
use Go\Connection as Connection;
use Go\AppModel as AppModel;

/***********************************
* 2016-11-17                       *
* Klevis Cipi                      * 
* cipiklevis@gmail.com             * 
*                                  * 
***********************************/

class BooksModel extends AppModel
{	
	private $table 			= 'books';
	private $table_authors  = 'author_books';
	public function books(){

	   $sql = $this->raw("SELECT * FROM $this->table");
		while ($row = $sql->fetch($this->obj)) {
			$list[]=$row;
		}
		return $list;
	}
	public function authors(){

	   $sql = $this->raw("SELECT a.fullname,a.id,count(b.id) FROM $this->table_authors AS a INNER JOIN $this->table AS b ON (b.author_id =a.id ) GROUP BY a.fullname,a.id");

		while ($row = $sql->fetch($this->obj)) {
			$list[]=$row;
		}
		return $list;
	}
	public function book($id){

	   $sql = $this->raw("SELECT * FROM $this->table WHERE lower(google_id) = lower('$id')");
		while ($row = $sql->fetch($this->obj)) {
			$list[]=$row;
		}
		return $list;
	}
	public function author($id){

	   $sql = $this->raw("SELECT a.fullname,a.id,count(b.id) FROM $this->table_authors AS a INNER JOIN $this->table AS b ON (b.author_id =a.id ) WHERE a.id = $id GROUP BY a.fullname,a.id");
		while ($row = $sql->fetch($this->obj)) {
			$list[]=$row;
		}
		return $list;
	}
	public function author_books($id){

	   $sql = $this->raw("SELECT b.* FROM $this->table_authors AS a INNER JOIN $this->table AS b ON (b.author_id =a.id ) WHERE  a.id = $id");
		while ($row = $sql->fetch($this->obj)) {
			$list[]=$row;
		}
		return $list;
	}
	
	public function add($post){

		$sql ="INSERT INTO $this->table (id,googl_id,json_volume,previelink,title,author_id,author_name,publisher,publisherdate,description,categories,pages,rating,language) VALUES(id,:googl_id,:json_volume,:previelink,:title,:author_id,:author_name,:publisher,:publisherdate,:description,:categories,:pages,:rating,:language)";

		$save=$this->pdo->prepare($sql);
		$save->bindValue(':googl_id',strtolower($post['googl_id']));
		
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
	public function delete($id){
		$sql = "DELETE FROM $this->table WHERE id = $id";
		$sql = $this->pdo->prepare($sql);
		$delete = $sql->execute();
		if($delete){
			return true;
		}else return false;
	}

	public function update($id,$post){
	
	$sql ="UPDATE $this->table SETgoogl_id = :googl_id,json_volume = :json_volume,previelink = :previelink,title = :title,author_id = :author_id,author_name = :author_name,publisher = :publisher,publisherdate = :publisherdate,description = :description,categories = :categories,pages = :pages,rating = :rating,language = :language  WHERE id=:id";	
		$save=$this->pdo->prepare($sql);
	
		$save->bindValue(':googl_id',strtolower($post['googl_id']));
		
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

	public function statistics(){
		$sqlbooks = $this->raw("SELECT count(*) FROM $this->table");
			$list['books']=$sqlbooks->fetch($this->obj);

		$sqlauthors = $this->raw("SELECT count(*) FROM $this->table_authors");
			$list['authors']=$sqlauthors->fetch($this->obj);

		$sqlempty = $this->raw("SELECT count(*) FROM $this->table WHERE author_name IS NULL AND author_id IS NULL ");
			$list['bookemptyauthor']=$sqlempty->fetch($this->obj);

		// $sqlemptyauthors = $this->raw("SELECT count(*) FROM $this->table_authors WHERE fullname =''");
		// 	$list['bookemptyauthor']=$sqlemptyauthors->fetch($this->obj);

		return (object) $list;
	}

}