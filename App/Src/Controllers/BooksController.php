<?php
namespace Go;
use Go\AppController as AppController;
use Go\Crypt as Crypt;

/***********************************
* 2016-11-17                       *
* Klevis Cipi                      * 
* cipiklevis@gmail.com             * 
*                                  * 
***********************************/

class BooksController extends AppController
{

	public function index(){

	    $data['title'] = 'Index';
	    $data['headertitle'] = 'Index page';
	    $data['content-title']='Index';
	    $data['books']=$this->Model->books();

		Template::View($this->Folder,'Index',$data,$error);
	}
	public function view($id){
		if(empty($id)){
			$this->msg->error('Empty id or id don\'t exists', '/');
		}else{
		   $id = Crypt::deTokenid($id);
		}
	    $data['title'] = 'View book';
	    $data['headertitle'] = 'View book';
	    $data['content-title']='View book';
	    $data['book']=$this->Model->book($id)[0];

		Template::View($this->Folder,'View',$data,$error);
	}
	public function add(){

	    $data['title'] = 'Add';
	    $data['headertitle'] = 'Add page';
	    $data['content-title']='Index';
	    //$post = $_POST;
	   	//$book=$this->Model->add($post);
		Template::View($this->Folder,'Add',$data,$error);
	}

	public function edit($id=''){
		if(empty($id)){
			$this->msg->error('Empty id or id don\'t exists', '/');
		}
		$post = $_POST;
	    $data['title'] = 'Edit';
	    $data['headertitle'] = 'Edit page';
	    $data['content-title']='Edit';
	    $book=$this->Model->update($id,$post);
		Template::View($this->Folder,'Edit',$data,$error);
	}

	public function delete($id=''){
		if(empty($id)){
			$this->msg->error('Empty id or id don\'t exists', '/');
		}
	    
	    $delete = $this->Model->delete($id);

	    if($delete){
	    	$this->msg->success('Empty id or id don\'t exists', '/Books/index');
	    }
	}
	/*************************Authors******************************/
	public function authors(){

	    $data['title'] = 'Authors';
	    $data['headertitle'] = 'Authors page';
	    $data['content-title']='Authors';
	    $data['authors']=$this->Model->authors();

		Template::View($this->Folder,'Authors',$data,$error);
	}
	public function viewauthors($id){
		if(empty($id)){
			$this->msg->error('Empty id or id don\'t exists', '/');
		}else{
		   $id = Crypt::deTokenid($id);
		}
		

	    $data['title'] = 'View book';
	    $data['headertitle'] = 'View book';
	    $data['content-title']='View book';
	    $data['author']=$this->Model->author($id)[0];
	    $data['author_books']=$this->Model->author_books($id);

		Template::View($this->Folder,'Viewauthors',$data,$error);
	}

	public function statistics(){
		$data['title'] 		 	= 'Statistics';
	    $data['headertitle'] 	= 'Statistics page';
	    $data['content-title']	='Statistics';
	    $data['statistics']		=$this->Model->statistics();

		Template::View($this->Folder,'Statistics',$data);

	}
}