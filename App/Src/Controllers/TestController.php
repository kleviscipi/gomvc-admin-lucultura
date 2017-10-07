<?php
namespace Go;
use Go\AppController as AppController;

/***********************************
* 2017-10-07                       *
* Klevis Cipi                      * 
* cipiklevis@gmail.com             * 
*                                  * 
***********************************/

class TestController extends AppController
{

	public function index(){

	    $data['title'] = 'Index';
	    $data['headertitle'] = 'Index page';
	    $data['content-title']='Index';
	    $data['test']=$this->Model->test();

		Template::View($this->Folder,'Index',$data,$error);
	}
	public function view($id){
		if(empty($id)){
			$this->msg->error('Empty id or id don\'t exists', '/');
		}
	    $data['title'] = 'View test';
	    $data['headertitle'] = 'View test';
	    $data['content-title']='View test';
	    $data['test']=$this->Model->test($id)[0];

		Template::View($this->Folder,'View',$data,$error);
	}
	public function add(){

	    $data['title'] = 'Add';
	    $data['headertitle'] = 'Add page';
	    $data['content-title']='Index';
	    $post = $_POST;
	   	$test=$this->Model->add($post);
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
	    $test=$this->Model->update($id,$post);
		Template::View($this->Folder,'Edit',$data,$error);
	}

	public function delete($id=''){
		if(empty($id)){
			$this->msg->error('Empty id or id don\'t exists', '/');
		}
	    
	    $delete = $this->Model->delete($id);

	    if($delete){
	    	$this->msg->success('Empty id or id don\'t exists', '/index');
	    }
	}

}