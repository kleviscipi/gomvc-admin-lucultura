<?php

namespace Go;

use Go\ApiController as ApiController;

/**
* klevis cipi
*/
class PageApiController extends ApiController
{

	public function index(){

	    $data['title'] = 'INdex';
		echo $this->before();
		echo $this->Language->get('wel');

		$error[] = "Weerore 1";
		$error[] = "Weerore 2";
		$error[] = "Weerore 3";

		$this->json($data);
	}

	public function start(){
		$data['text']=  "from api";
		$this->json($data);
	}

	public function all(){
		$data['text']=  "from api all";
		$this->json($data);
	}
}