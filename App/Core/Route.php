<?php
namespace Go;
use Go\Error as Error;
use Go\Template as Template;
use Go\Link as Link;
use Go\Connection as Connection;
use Go\ApiModel as ApiModel; 
use Go\AdminModel as AdminModel;
use Go\Ip as Ip;


/**
* klevis cipi 2016, cipiklevis@gmail.com
*/
class Route 
{
	public $url = [];
	public $model;
	public $ip;

	public function __construct()
	{	
		$this->model = new AdminModel();
		$this->getUri();
		$this->visits();


	}

	public function getUri(){
		$get_url = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '/';
 		$get_url = explode('/', rtrim($get_url, '/'));
 		if (empty($get_url[3])) $get_url[3] = "";
 		if (empty($get_url[4])) $get_url[4] = "";
 		if (empty($get_url[5])) $get_url[5] = "";
 		if (empty($get_url[6])) $get_url[6] = "";
 		$this->url = [
 		 	'index'		=>$get_url[0],
 			'controller'=>$get_url[1],
 			'action'	=>$get_url[2],
 			'param1'	=>$get_url[3],
 			'param2'	=>$get_url[4],
 			'param3'	=>$get_url[5],
 			'param4'	=>$get_url[6]
 		];
 		$this->where($this->url['controller'],$this->url['action'],$this->url['param1'],$this->url['param2'],$this->url['param3']);

 		if(empty($this->url['controller'])){
	 		if(empty(Session::get('username')) && empty(Session::get('email')) && empty(Session::get('iduser'))){
	 				
	 				if(empty(Session::get('guest'))){
						Render::View('Admin','Login');
	 				}else{
	 					Template::View(DEFAULT_CONTROLLER,DEFAULT_METHOD);
	 				}
	 		}else{
	 			Template::View(DEFAULT_CONTROLLER,DEFAULT_METHOD);
	 		}
			
 		}else{
	 		$uri = $this->url['controller'];
	 		if(ucfirst($uri) == 'Api') return Error::display('You cant\'use this name because it is used on api route!');
	 		
			$class_controller 	= COMPOSER_PRS.'\\'.$uri.'Controller';
			$class_model 		= COMPOSER_PRS.'\\'.$uri.'Model';
			
			
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

				$error = new Error;
				$error->index('PAGE DONT"T EXIST');
 			}
			
 		}

	}

	public function ifmethod($controller,$method,$param1=null,$param2=null,$param3=null,$param4=null){
		if(method_exists($controller,$method)){

			return $controller->$method($param1,$param2,$param3,$param4);
		}else{
			$error = new Error;
			$error->index('METHOD INDEX DONT"T EXIST');
			return $error;
		}

	}
	public  function where($controller ='',$method='',$param1=null,$param2=null,$param3=null,$param4=null)
	{
		if(!empty($controller)) $GLOBALS['class'] 		= ucfirst($controller);
		if(!empty($method)) 	$GLOBALS['method'] 		= ucfirst($method);
		if(!empty($param1)) 	$GLOBALS['param1'] 		= ucfirst($param1);
		if(!empty($param2)) 	$GLOBALS['param2'] 		= ucfirst($param2);
		if(!empty($param3)) 	$GLOBALS['param3']		= ucfirst($param3);
	}
	public function initHeader(){

		Template::Header(); // header
	}
	public function initFooter(){
		
		Template::Footer(); // header
	}
	public function visits(){
		$ip      = Ip::getIp();
		$broswer = $_SERVER['HTTP_USER_AGENT'];
		$ifip = $this->model->ifip($ip);
		if($ifip['ifip']->count  < 1) {
			    $broswer=Ip::getBrowser();
			    $thatbrowser= $broswer['name'] . " " . $broswer['version'] . " on " .$broswer['platform'];
			 $this->model->visits($ip,$thatbrowser);
		} 
		
	}

}
