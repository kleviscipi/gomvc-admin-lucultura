<?php 
namespace Go;

use Go\Route as Route;
use Go\Config as Config;
use Go\Template as Template;
use Go\Render as Render;
use Go\Session as Session;


class App
{

	public function init(){
			
		$this->initSession();

		$this->initConfigs();
		
		$route = new Route; //route

	}
	public function initApi(){
		$this->initSession();
		$this->initConfigs();
		$route = new ApiRoute; //route


	}
	public function initConfigs(){

		$config = new Config; //default configs
	}

	public function initSession(){
		ob_start();
		Session::init(); // start session
	}

}