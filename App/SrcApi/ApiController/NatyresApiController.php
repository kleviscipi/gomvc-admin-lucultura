<?php
namespace Go;
use Go\ApiController as ApiController;

/***********************************
* 2016-11-18                       *
* Klevis Cipi                      * 
* cipiklevis@gmail.com             * 
*                                  * 
***********************************/

class NatyresApiController extends ApiController
{

	public function index(){
		$natyres = $this->Model->natyres();

		if(empty($natyres)){
			$response['data'] 	= '';
			$response['error']	=1;
		}else{
			$response['data'] 	= $natyres;
			$response['error']	=0;
		}
		
		$this->json($response);
	}
	public function view(){
		$id = $_POST['id'];
		$natyre= $this->Model->natyre($id);

		if(empty($natyre)){
			$response['data'] 	= '';
			$response['error']	=1;
		}else{
			$response['data'] 	= $natyre;
			$response['error']	=0;
		}
		
		$this->json($response);
		
	}
	public function add(){
		$post 		= $_POST;
		$key 		= $post['keyapi'];
		$keyword    = $post['img_id'];
		$text 		= urlencode(trim($keyword));
		$urls  		= 'https://pixabay.com/api/?key='.$key.'&q='.$keyword.'&image_type=photo&pretty=true&per_page=200';
		$url 		= file_get_contents($urls);
		$imgs 		= json_decode($url);

		$counts = 0;
		if(!empty($imgs)){
			foreach ($imgs->hits as $key => $img) {
				$count = $this->Model->ifexist($img->id);
				if($count->images->count < 1){
					$post_json=[			
						'web_id'		=>$img->id,							
						'webwidth'		=>$img->imageWidth, 		
						'webheight'		=>$img->imageHeight, 		 				
						'pageurl'		=>$img->pageURL, 		
						'weburl'		=>$img->webformatURL, 			
						'tags'			=>$img->tags,
					];

				$add = $this->Model->add($post_json);
					if($add){
						$error['img'] = 0;
						$counts +=1;
					}else{
						$error['img'] += 1;
					}					
				}
			}
			if($error['img'] < 1){
				$response['sms'] 	= "Congrutalations request executet successfully, $counts images insertet successfully.";
				$response['error']	=0;
				if($counts > 0){

					$controller  = "Natyres";
					$description = "Inserted $counts images";
					$this->Model->insertactions('Add',$controller,$description,Session::get('iduser'),$count);
				}
			}else{
				$response['sms'] 	="Errors... ".$error['img']." ,check again.";
				$response['error']	=1;
			}
	
		}else{
			$response['sms'] 	="Error... empty json? $videos ";
			$response['error']	=1;
		}
		$this->json($response);
	}
	public function addvideo(){
		$post 		= $_POST;
		$key 		= $post['keyapi'];
		$keyword    = $post['video_id'];
		$text 		= urlencode(trim($keyword));
		$urls  		= 'https://pixabay.com/api/videos/?key='.$key.'&per_page=200&q='.$keyword.'';
		$url 		= file_get_contents($urls);
		$videos 		= json_decode($url);
		$counts = 0;
		if(!empty($videos)){
			foreach ($videos->hits as $key => $video) {
				$count = $this->Model->ifexist($video->id);
				if($count->video->count < 1){
					$post_json=[			
						'web_id'		=>$video->id,							
						'picture_id'	=>$video->picture_id,		
						'webwidth'		=>$video->videos->large->width, 		
						'webheight'		=>$video->videos->large->height, 		
						'size'			=>$video->videos->large->size,	 				
						'pageurl'		=>$video->pageURL, 		
						'weburl'		=>$video->videos->large->url, 			
						'tags'			=>$video->tags,			
						'duration'		=>$video->duration 		

					];
				if(!empty($video->videos->large->url)){
					$add = $this->Model->addvideo($post_json);
						if($add){
							$error['video'] = 0;
							$counts +=1;
						}else{
							$error['video'] += 1;
						}	
				}
				
				}
			}
			if($error['video'] < 1){
				$response['sms'] 	= "Congrutalations request executet successfully, $counts video insertet successfully.";
				$response['error']	=0;
				if($counts > 0){

					$controller  = "Natyres";
					$description = "Inserted $counts videos";
					$this->Model->insertactions('Add',$controller,$description,Session::get('iduser'),$count);
				}
			}else{
				$response['sms'] 	="Error... $counts are inserted, check again.";
				$response['error']	=1;
			}
	
		}else{
			$response['sms'] 	="Error... empty json? $videos ";
			$response['error']	=1;
		}
		
		$this->json($response);

	}
	public function delete(){

		$id =$_POST['id'];
		if(empty($id)){
			$response['sms'] 	= 'Id is impty please check again!';
			$response['error']	=1;		
		}else{
			$delete = $this->Model->delete($id);

			if($delete){
				$controller  = "Natyres";
				$description = "Deleted 1 image";
				$this->Model->insertactions('Delete',$controller,$description,Session::get('iduser'),1);
		
				$response['sms'] 	= 'Item deletet successfully.';
				$response['error']	=0;
			}else{
				$response['sms'] 	= 'Item not deletet.';
				$response['error']	=1;
			}
		}

		
		$this->json($response);
	}

	public function deletevideo(){

		$id =$_POST['id'];
		if(empty($id)){
			$response['sms'] 	= 'Id is impty please check again!';
			$response['error']	=1;		
		}else{
			$id = Crypt::deTokenid($id);
			$delete = $this->Model->delete($id);

			if($delete){
				$controller  = "Natyres";
				$description = "Deleted 1 video";
				$this->Model->insertactions('Delete',$controller,$description,Session::get('iduser'),1);
		
				$response['sms'] 	= 'Video deletet successfully.';
				$response['error']	=0;
			}else{
				$response['sms'] 	= 'Video not deletet.';
				$response['error']	=1;
			}
		}

		
		$this->json($response);
	}
}