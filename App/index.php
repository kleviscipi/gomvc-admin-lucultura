<?php  

namespace Go;
use Go\App as App;
use Go\Link as Link;
require_once($_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php');

define('DIR_VENDOR', dirname(dirname(__FILE__)));
define('DIR_BASE', dirname(DIR_VENDOR));
define("ROOT",dirname(__FILE__)); //NOIN MODIFICARE E STATO USATO IN MOLTI CASI 

$inituri =Link::detectUri();

if(isset($inituri)) $inituri = explode('/',$inituri);

$app=new App(); // start app

if($inituri[0] == 'Api'){
	$app->initApi();
}else $app->init();
