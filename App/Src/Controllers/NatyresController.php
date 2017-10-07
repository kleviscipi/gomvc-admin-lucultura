<?php
namespace Go;
use Go\AppController as AppController;
use Go\Paginator as Paginator;
use Go\Crypt as Crypt;

/***********************************
* 2016-11-18                       *
* Klevis Cipi                      * 
* cipiklevis@gmail.com             * 
*                                  * 
***********************************/

class NatyresController extends AppController
{

	public function index(){

	    $data['title'] = 'Index';
	    $data['headertitle'] = 'Index page';
	    $data['content-title']='Index';

        $pages = new Paginator("50",'text');

        $data['natyres']  = $this->Model->natyres($pages->getLimit());
        $pages->setTotal($data['natyres'][0]->total);
        $data['pageLinks']       = $pages->pageLinks();

		Template::View($this->Folder,'Index',$data);
	}
	public function videos(){

	    $data['title'] = 'Videos';
	    $data['headertitle'] = 'Videos page';
	    $data['content-title']='Index';
        $data['videos']  = $this->Model->videos();

		Template::View($this->Folder,'Videos',$data);
	}
	public function view($id){
		if(empty($id)){
			$this->msg->error('Empty id or id don\'t exists', '/');
		}else{
			$id = Crypt::deTokenid($id);
		}
	    $data['title'] = 'View natyre';
	    $data['headertitle'] = 'View natyre';
	    $data['content-title']='View natyre';
	    $data['natyre']=$this->Model->natyre($id)[0];

		Template::View($this->Folder,'View',$data);
	}

	public function viewvideo($id){
		if(empty($id)){
			$this->msg->error('Empty id or id don\'t exists', '/');
		}else{
			$id = Crypt::deTokenid($id);
		}
	    $data['title'] = 'Video';
	    $data['headertitle'] = 'View video';
	    $data['content-title']='View video';
	    $data['video']=$this->Model->video($id)[0];

		Template::View($this->Folder,'Viewvideo',$data);
	}
	public function add(){

	    $data['title'] = 'Add';
	    $data['headertitle'] = 'Add page';
	    $data['content-title']='Index';
	    //$post = $_POST;
	   	//$natyre=$this->Model->add($post);
		Template::View($this->Folder,'Add',$data);
	}

	public function edit($id=''){
		if(empty($id)){
			$this->msg->error('Empty id or id don\'t exists', '/');
		}
		$post = $_POST;
	    $data['title'] = 'Edit';
	    $data['headertitle'] = 'Edit page';
	    $data['content-title']='Edit';
	    $natyre=$this->Model->update($id,$post);
		Template::View($this->Folder,'Edit',$data);
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