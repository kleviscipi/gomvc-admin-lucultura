<?php 
namespace Go;
class Config
{
	public function __construct(){

       
        define('SITEURL', 'http://gomvc-admin.local'); //SITE URL IS USED ON ALL, PLEASE CHECK BEFORE CHANGE THIS
        define("SITE_LINK", "http://gomvc-admin.local" );
        define('DIR', '/');
        define('TARGETMOVIE','/home/datawebsites/movies/');
        define('CRONDIR','/home/');//USE ON CRON FOLDER FOR FILES, MODIFIC BY SELF
        define('DIR_APP', 'App');
        define('DIR_VIEW', 'Views');
        define('DIR_VIEW_ASSETS', 'Assets');
        define('DIR_TEMPLATE', 'Templates');
        define('DIR_CONTROLLER', 'Controllers');
        define('DIR_MODEL', 'Models');
        define('DIR_SRC', 'Src');
        define('DEFAULT_CONTROLLER', 'Welcome');
        define('DEFAULT_METHOD', 'index');
        define('TEMPLATE', 'Matrix');
        define('LANGUAGE_CODE', "en");
        define('DB_TYPE', 'POSTGRES'); // MYSQL OR POSTGRES (FOR NOW IS UPPORTED JUST POSTGRES SQL MYSQL IS JUST  FOR A TEST)
        define('DB_HOST', '');
        define('DB_NAME', 'dbname');
        define('DB_USER', 'root');
        define('DB_PASS', 'password');
        define('PREFIX', 'go_');
        define('SESSION_PREFIX', 'go_');
        //---
        define('SITETITLE', 'New Mvc Go');
        define('COMPOSER_PRS','Go');
        //** create files
        define('CREATE_FILE_CONTROLLER',ROOT.DIR.DIR_SRC.DIR.DIR_CONTROLLER.DIR);
        define('CREATE_FILE_MODEL',ROOT.DIR.DIR_SRC.DIR.DIR_MODEL.DIR);
        define('CREATE_FILE_APICONTROLLER',ROOT.DIR.'SrcApi/ApiController/');
        define('CREATE_FILE_APIMODEL',ROOT.DIR.'SrcApi/ApiModel/');

        define('ROOT_ASSETS',ROOT.DIR.DIR_TEMPLATE.DIR.TEMPLATE.DIR.DIR_VIEW_ASSETS.DIR);
        define('URL_ASSETS',SITEURL.DIR.DIR_APP.DIR.DIR_TEMPLATE.DIR.TEMPLATE.DIR.DIR_VIEW_ASSETS.DIR);
        define('ROOT_VIEWS',ROOT.DIR.DIR_SRC.DIR.DIR_VIEW.DIR);
        define('URL_VIEWS',SITEURL.DIR.DIR_APP.DIR.DIR_SRC.DIR.DIR_VIEW.DIR);
        define('URL_PLUGIN',SITEURL.DIR.'webroot'.DIR.'plugins');
        define('KEY_API','weiufo0urefm9034!@#@&*&#$#$68691898*@!plob0215');// Attenzion.... 
        define('KEY','weiufo0ure5gp!@#@&*&#$#$68691898*@!plob0215');// Attenzion.... 
        define('KEY_TOKEN','weiufo0uEEGjhfiwerugmki837482395$$$91898*@!plob0215');// Attenzion.... 
        define('PASSWORD_DEFAULT','ifhiml58*woiu23423wg11*&6r4we$$#@@~#@$@#fik');// Attenzion.... 
        date_default_timezone_set('Europe/London');

	}

}