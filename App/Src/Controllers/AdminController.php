<?php

namespace Go;

use Go\AppController as AppController;
use Go\Link as Link;
use Go\Paginator as Paginator;
/**
* klevis cipi
*/
class AdminController extends AppController
{

	public function index(){

	    $data['title'] = 'Index';
	    $data['headertitle'] = 'Home page';
		Template::View($this->Folder,'Index',$data,$error = 0);
	}

	public function login(){
		$data['title'] = 'Login';

		Render::View($this->Folder,'Login',$data);

	}
	public function add(){
	
		Template::View($this->Folder,'Add',$data,$error = 0);	
	}
	public function users(){
	    
		Template::View($this->Folder,'Users',$data,$error = 0);	
	}

	public function profile($ids=''){
		$data['title'] = 'Profile';
	    $data['headertitle'] = 'Profile';
	    $data['content-title']='Profile';
    	if(empty($ids)){
		    $id    = Session::get('iduser');
		    $email = Session::get('email');
		    if(!empty($id) && !empty($email)){
		    	$data['user'] = $this->Model->user($id,$email);
		    }	  
		}else{
		   $ids = Crypt::deTokenid($ids);
		   $checkifexist = $this->Model->ifuserexist($ids);

		   if($checkifexist['user']->count > 0){
  				$data['user'] = $this->Model->userfromlist($ids);
		   }else{
		   	$this->msg->error('Empty id or user don\'t exists', '/');
		   }
		 
		}
		Template::View($this->Folder,'Profile',$data,$error = 0);	
	}
	public function Search(){
		
		$data['title'] = 'Search';
	    $data['headertitle'] = 'Search page';
	    $data['content-title']='Search';
	    $pages = new Paginator("3",'words');
	    $words 		= $_GET['rf_words'];
		$words_page = $_GET['words'];
	    $words = rawurldecode($words);

		if(!empty(Session::get('searchwords'))){
			if(strtolower(trim(Session::get('searchwords')))==strtolower(trim($words))){
				$sessionword = Session::get('searchwords');
			}else{
				if(!empty($words)){
					Session::set('searchwords',$words);
					$sessionword = Session::get('searchwords');
				}else{
					$sessionword = Session::get('searchwords');
				}
			}
		}else{
			if(!empty($words)){
				Session::set('searchwords',$words);
				$sessionword = Session::get('searchwords');	
			}else{
				$sessionword = Session::get('searchwords');	
			}
		
		}
		if( empty( $words_page ) && empty( $words ) ){
			Session::destroy('searchwords');
		}else{
		    $data['searchs']  = $this->Model->searchs($pages->getLimit(),$sessionword);
		    $total = $data['searchs']['actors'][0]->total + $data['searchs']['movies'][0]->total + $data['searchs']['books'][0]->total + $data['searchs']['authors'][0]->total;
		    $pages->setTotal($total);
		    $data['pageLinks']       = $pages->pageLinks();
		}
		Template::View($this->Folder,'Search',$data,$error = 0);	
	}
	public function notifications(){
		$data['title'] = 'Notifications';
	    $data['headertitle'] = 'Notifications page';
	    $data['content-title']='Notifications';
	    
		Template::View($this->Folder,'Notifications',$data,$error = 0);	
	}
	public function cronjobs($action){
		require_once ROOT.'/Core/_data/cron/Cron_Terminal_Natyres.php';
		 $obj = new Cron_Natyres();

		switch ($action) {
			case 'img':
				$obj->optimizeimages();
			    echo "End.....Thank you."."<br>";
				break;
			case 'videos':
				$obj->optimizevideos();
				$obj->emptyurls();
				echo "End.....Thank you."."<br>";
				break;
			case 'start':
				$obj->test();
				break;		
			case 'backupcsv':
				$db = $this->Model->csv_db();
				if($db){
					echo "Csv files createt succesfully". "<br>";
				}
				break;
			case 'importcsv':
				$db = $this->Model->import_csv_db();
				if($db){
					echo "Csv files imported succesfully". "<br>";
				}
				break;
			case 'Y:dropall':
				$db = $this->Model->dropdb();
				if($db){
					echo "Tables deletet succesfully". "<br>";
				}
				break;
			case 'Y:deleteall':
				$db = $this->Model->deletedb();
				if($db){
					echo "Records deletet succesfully on alla tables". "<br>";
				}
				break;
			case 'tables':
				echo "<br>";
	   		    $tables = $this->Model->schema()->schema;
	   		    $i = 0;
			    foreach ($tables as $key => $table) {
			    	echo $i .' : '. $table->table_name . "<br>";
			    	$i++;
			    }
				echo "End list";
				break;
					
		}
		if(!empty($action)){
			$action = explode(':',$action);
			if($action[0] == "drop-table"){
				echo "<br>";
				$delete = $this->Model->droptable($action[1]);
				if($delete){
					echo "Table deletet succesfully". "<br>";
				}
			echo "End..";
			}
			if($action[0] == "delete-table"){
				echo "<br>";
				$delete = $this->Model->deletetable($action[1]);
				if($delete){
					echo "Records deletet succesfully". "<br>";
				}
			echo "End..";
			}

		}
		
	}
}