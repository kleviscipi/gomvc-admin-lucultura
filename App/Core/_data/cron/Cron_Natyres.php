<?php 
namespace Go;
$path_url = 'this is your path og your project /home/ect ect';
$url =  $path_url.'/vendor/autoload.php';

require_once($url);

define('DIR_VENDOR', dirname(dirname(__FILE__)));
define('DIR_BASE', dirname(DIR_VENDOR));
define("ROOT",dirname(__FILE__)); //NOIN MODIFICARE E STATO USATO IN MOLTI CASI

use Go\Connection as Connection;
use Go\ApiModel as ApiModel; 
use Go\NatyresApiModel as NatyresApiModel;
$config = new Config;

class Cron_Natyres 
{	private $model;
	private $urlimg 	= "https://pixabay.com/api/?key=";
	private $urlvideo 	= "https://pixabay.com/api/videos/?key=";
	private $key 		= "3788418-e2d1fda475bb9e8eb53575098";
	private $time_start     =   0;
    private $time_end       =   0;
    private $time           =   0;
    private $actionby 		=[
    	'0'=>'System',
    	'1'=>'User'
    ];
    private $type_img 		= "images";
    private $type_videos 	= "video";
    private $cronjobs 		= 0;

    public function __construct(){

    	$this->model = new NatyresApiModel;
 	
    }

	public function optimizeimages(){
		$this->time_start = microtime(true);
		
	    $images = $this->model->natyres();

	    foreach ($images as $key => $image) {
	    	$url = $this->urlimg.$this->key.'&id='.$image->web_id;
	    	$urls = file_get_contents($url);
	    	$data = json_decode($urls);
	    	$img = $data->hits[0];
	    	if(!empty($img)){
		    	$post_json=[

							'web_id'		=>$img->id,							
							'webwidth'		=>$img->imageWidth, 		
							'webheight'		=>$img->imageHeight, 		 				
							'pageurl'		=>$img->pageURL, 		
							'weburl'		=>$img->webformatURL, 			
							'tags'			=>$img->tags
		    	];
		    	$update = $this->model->update($image->id,$post_json);
		    	if($update){
		    		$this->cronjobs +=1;
		    	}else{
		    		$this->cronjobs -=1;
		    	}
	    	}else{
	    		$this->cronjobs -=1;	
	    	}

	    }
	    $this->time_end = microtime(true);
	    $this->time =$this->time_end - $this->time_start;

	    $this->cronjobs($this->type_img,$this->actionby[0],$this->time,$this->cronjobs);
	}
	public function optimizevideos(){
		$this->time_start = microtime(true);
		
	    $videos = $this->model->videos();

	    foreach ($videos as $key => $video) {
	    	$url = $this->urlvideo.$this->key.'&id='.$video->web_id;
	    	$urls = file_get_contents($url);
	    	$data = json_decode($urls);
	    	echo $url;
	    	$vid = $data->hits[0];
	    	if(!empty($vid)){
				$post_json=[			
					'web_id'		=>$vid->id,							
					'picture_id'	=>$vid->picture_id,		
					'webwidth'		=>$vid->videos->large->width, 		
					'webheight'		=>$vid->videos->large->height, 		
					'size'			=>$vid->videos->large->size,	 				
					'pageurl'		=>$vid->pageURL, 		
					'weburl'		=>$vid->videos->large->url, 			
					'tags'			=>$vid->tags,			
					'duration'		=>$vid->duration 		

				];
				if(!empty($vid->videos->large->url)){
			    	$update = $this->model->updatevideo($video->id,$post_json);

				    if($update){
			    		$this->cronjobs +=1;
			    	}else{
			    		$this->cronjobs -=1;
			    	}
				}

	    	}else{
	    		$this->cronjobs -=1;
	    	}

	    }
	    $this->time_end = microtime(true);
	    $this->time =$this->time_end - $this->time_start;

	    $this->cronjobs($this->type_videos,$this->actionby[0],$this->time,$this->cronjobs);
				
	}
	public function emptyurls(){
		$sqlcron = "DELETE FROM videonatyres WHERE weburl = ''";
		$sql=$this->model->pdo->prepare($sqlcron);
		$final  =$sql->execute();
		if($final){
			return true;
		}else return false;
	}
	public function cronjobs($type,$actionby,$duration,$records){

		$sqlcron = "INSERT INTO cronjobs(type,actionby,duration,records) VALUES(:type,:actionby,:duration,:records)";
		$sql=$this->model->pdo->prepare($sqlcron);

		$sql->bindValue(':type',$type);
		$sql->bindValue(':actionby',$actionby);
		$sql->bindValue(':duration',$duration);
		$sql->bindValue(':records',$records);

		$final  =$sql->execute();
		if($final){
			return true;
		}else return false;
			
	}

}

$obj = new Cron_Natyres();
$action = ((isset($argv[1]))?($argv[1]):(""));

switch ($action) {
	case 'img':
		$obj->optimizeimages();
		break;

	case 'videos':
		$obj->optimizevideos();
		$obj->emptyurls();
		break;	
}