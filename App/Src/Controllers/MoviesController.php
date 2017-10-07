<?php
namespace Go;
use Go\AppController as AppController;
use Go\Crypt AS Crypt;
use Go\Media AS Media;
/***********************************
* 2016-11-16                       *
* Klevis Cipi                      * 
* cipiklevis@gmail.com             * 
*                                  * 
***********************************/

class MoviesController extends AppController
{

	public function index(){

	    $data['title'] = 'Index';
	    $data['headertitle'] = 'Index page';
	    $data['content-title']='Index';
	    $data['movies']=$this->Model->movies();
	    $data['actors']=$this->Model->actors();

		Template::View($this->Folder,'Index',$data);
	}

	public function actors(){

	    $data['title'] = 'Actors';
	    $data['headertitle'] = 'Actors page';
	    $data['content-title']='Index';
	    $data['actors']=$this->Model->actors();
		Template::View($this->Folder,'Actors',$data);
	}
	public function companies(){

	    $data['title'] = 'Actors';
	    $data['headertitle'] = 'Actors page';
	    $data['content-title']='Index';
	    $data['actors']=$this->Model->actors();
		Template::View($this->Folder,'Actors',$data);
	}
	public function view($id){
		if(empty($id)){
			$this->msg->error('Empty id or id don\'t exists', '/');
		}else{
			$id = Crypt::deTokenid($id);
		}

	    $data['title'] = 'View movie';
	    $data['headertitle'] = 'View movie';
	    $data['content-title']='View movie';
	    $data['movie']=$this->Model->movie($id);

		Template::View($this->Folder,'View',$data);
	}

	public function viewactor($id){
		if(empty($id)){
			$this->msg->error('Empty id or id don\'t exists', '/');
		}else{
			$id = Crypt::deTokenid($id);
		}
	    $data['title'] = 'View Actor';
	    $data['headertitle'] = 'View Actor';
	    $data['content-title']='View Actor';
	    $data['actor']=$this->Model->actor($id)[0];
	    if(empty($data['actor'])){
	    	$this->msg->error('Empty no data.......');
	    }
	    $data['actor_movies']=$this->Model->actor_movies($id);

		Template::View($this->Folder,'Viewactor',$data);
	}
	public function add(){

	    $data['title'] = 'Add';
	    $data['headertitle'] = 'Add page';
	    $data['content-title']='Index';
	    //$post = $_POST;
	   	//$movie=$this->Model->add($post);
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
	    $movie=$this->Model->update($id,$post);
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
	public function statistics(){
		$data['title'] 		 	= 'Statistics';
	    $data['headertitle'] 	= 'Statistics page';
	    $data['content-title']	='Statistics';
	    $data['statistics']		=$this->Model->statistics();

		Template::View($this->Folder,'Statistics',$data);

	}
	public function addonheaderimg(){
	     $file['name'] = basename($_FILES["name"]["name"]);
	     $file['temp_name'] = $_FILES["name"]["tmp_name"];
	     $target = TARGETMOVIE;
	     $img  = Media::uploadFile( $file, $target);
        $val = $img;
        $idmovie = $_POST['idmovie'];
        $id = Crypt::Tokenid($idmovie);
        $path = "/Movies/View/".$id;
		if(!empty($val) && !empty($idmovie)){
			$ifexist=$this->Model->ifimageexist($idmovie);
			if($ifexist){
				$update =$this->Model->updateimgheader($idmovie,$val);
				if($update){
					$this->msg->success('Image update successfully', $path);	
				}else{
					$this->msg->error('Image update successfully', $path);	
				}
			}else{
				$insert =$this->Model->insertimgheader($idmovie,$val);
				if($insert){
					$this->msg->success('Image inserted successfully',$path);		
				}else{
					$this->msg->error('Image not inserted',$path);	
				}
			}
		}else{
			$this->msg->error('File empty please try again', $path);		
		}	
	

	}
}