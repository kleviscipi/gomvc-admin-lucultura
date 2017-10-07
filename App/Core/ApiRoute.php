<?php
namespace Go;
use Go\Error as Error;

/**
* klevis cipi 2016, cipiklevis@gmail.com
*/
class ApiRoute 
{
	public $url = [];


	public function __construct()
	{

		$this->getUri();
	}

	public function getUri(){
		$get_url = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '/';
 		$get_url = explode('/', rtrim($get_url, '/'));
 		if(empty($get_url[5])){
 			$get_url[5] = "";
 		}
 		if(empty($get_url[6])){
 			$get_url[6] = "";
 		}
 		if(empty($get_url[4])){
 			$get_url[4] = "";
 		}
 		$this->url = [
 		 	'index'		=>$get_url[0],
 			'api'		=>$get_url[1],
 			'controller'=>$get_url[2],
 			'action'	=>$get_url[3],
 			'param1'	=>$get_url[4],
 			'param2'	=>$get_url[5],
 			'param3'	=>$get_url[6],
 			'param4'	=>$get_url[7]
 		];

 		if(empty( $this->url['controller'] ) && empty( $this->url['api'] )){
 			$error['error'] = 'Empty controller or api link start';
			echo json_encode($error);

 		}else{
	 		$uri 				= $this->url['controller'];
	 		$api 				= $this->url['api'];
			$class_controller 	= COMPOSER_PRS.'\\'.$uri.$api.'Controller';
			$class_model 		= COMPOSER_PRS.'\\'.$uri.$api.'Model';
			
			if(class_exists($class_controller)){

				$controller = new $class_controller(new $class_model,ucfirst($uri));

				if(empty($this->url['action'])){
					$this->ifmethod($controller,'index');
				}else{
					$action=$this->url['action'];
					if(empty($this->url['param1'])){
						$this->ifmethod($controller,$action);
					}else{
						if(!empty($this->url['param1'])
								 && empty($this->url['param2'])
								 	 && empty($this->url['param3'])
								 	 		&& empty($this->url['param4'] ) ){

						    $this->ifmethod($controller,$action,$this->url['param1']);

						}else if(!empty($this->url['param1'])
								 && !empty($this->url['param2'])
								 	 	&& empty($this->url['param3'])
								 	 		&& empty($this->url['param4']) ){

							$this->ifmethod(
											$controller,
											$action,
											$this->url['param1'],
											$this->url['param2']);


						}else if(!empty($this->url['param1'])
								 && !empty($this->url['param2'])
								 	 && !empty($this->url['param3'])
								 	 		&& empty($this->url['param4'])){

							$this->ifmethod(
											$controller,
											$action,
											$this->url['param1'],
											$this->url['param2'],
											$this->url['param3']);


						}else if(!empty($this->url['param1'])
								 && !empty($this->url['param2'])
								 	 && !empty($this->url['param3'])
								 	 		&& !empty($this->url['param4'])){

							$this->ifmethod(
											$controller,
											$action,
											$this->url['param1'],
											$this->url['param2'],
											$this->url['param3'],
											$this->url['param4']);


						}else{
							$controller->$action($this->url['param1']);

						}
						
					}
					
				}

 			}else{
 				echo json_encode('Error...... no file or directory find please check again your links!');

 			}
			
 		}

	}

	public function ifmethod($controller,$method,$param1=null,$param2=null,$param3=null,$param4=null){
		if(method_exists($controller,$method)){
			return $controller->$method($param1,$param2,$param3,$param4);
		}else{

 		echo json_encode('Error...... no file or directory ($controller / $method) find please check again your links!');

		}

	}
}
