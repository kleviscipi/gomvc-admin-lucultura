<?php

namespace Go;

use Go\AppController as AppController;

/**
* klevis cipi
*/
class PageController extends AppController
{

	public function index(){

	    $data['title'] = 'Index';
	    $data['headertitle'] = 'Home page';
		
		$this->Language->get('wel');

		$error[] = "Weerore 1";
		$error[] = "Weerore 2";
		$error[] = "Weerore 3";
		
		Template::View($this->Folder,'Index',$data);
	}

	public function start(){
		$data['title'] = 'STart';
		Session::GoFlash('namethisS','fhw9fwfw','flash_success');
		Session::GoFlash('namethisS');
		var_dump(Session::GoFlash('namethisS'));
		//echo $this::words('bsufd')->oupper;
		
		$d = $this->Model->schema()->schema;
		var_dump($d);
	
		Template::View($this->Folder,'Start',$data);

	}
}