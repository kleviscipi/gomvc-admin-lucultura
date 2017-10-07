<?php 
namespace Go;
/**
* 2016 Klevis Cipi cipiklevis@gmail.com
*/
class Create
{

	
	public static function SystemFiles($class_controller='',$tablecolumns =''){
		// if(empty($tablecolumns)){

		// }

	    if(DB_TYPE == "POSTGRES"){

				$postcontroller = trim($class_controller," ");
				$postcontroller = ucfirst($postcontroller);
				$postmodel = strtolower($postcontroller);
				$thatmodel = $postmodel;
				$thatmodel = rtrim($thatmodel,'s');

				if(!empty($postcontroller)){
					$classController 	= $postcontroller.'Controller';
					$classModel 		= $postcontroller.'Model';

					$classApiController = $postcontroller.'ApiController';
					$classApiModel 		= $postcontroller.'ApiModel';
				}

				$date = date('Y-m-d'); 
				if(!is_writable(CREATE_FILE_CONTROLLER)){
					chmod(CREATE_FILE_CONTROLLER, 0777);
				}
				$filecontroller 	= CREATE_FILE_CONTROLLER.$classController.'.php';		
				$filemodel 			= CREATE_FILE_MODEL.$classModel.'.php';
				$fileapicontroller 	= CREATE_FILE_APICONTROLLER.$classApiController.'.php';		
				$fileapimodel 		= CREATE_FILE_APIMODEL.$classApiModel.'.php';
				$folderView 		= ROOT.DIR.DIR_SRC.DIR.DIR_VIEW.DIR.$postcontroller;
				$file = ROOT.DIR.'Languages'.DIR;
				$allfolder = array_diff(scandir($file), array('..', '.'));
$datalanguage="
<?php


return [
	'wel'=>'QUesto e il titolo',
	//add
	'add_title'			=>'Add user',
	'add_name'			=>'First Name',
	'add_lastname'		=>'Last Name',
	'add_email'			=>'Email',
	'add_username'		=>'Username',
];

";
				   	foreach ($allfolder as $key => $folder) {

				   		$languagefile = ROOT.DIR.'Languages'.DIR.$folder.DIR.$postcontroller.'.php';
				   		if(!file_exists($languagefile)){
						    touch($languagefile);
						    chmod($languagefile, 0777);
						    $newFile= fopen($languagefile, 'w+');
							fwrite($newFile, $datalanguage);
							fclose($newFile);
				   		}

				   	}
				

				if (!is_dir($folderView )) {
				    mkdir( $folderView );
				    chmod( $folderView, 0777);

					$index 				= $folderView.DIR.'Index.php';
					$add 				= $folderView.DIR.'Add.php';
					$view 				= $folderView.DIR.'View.php';
$dataviews =
"<?php
use Go\Language as Language;
use Go\Media as Media;
use Go\Link as Link;
use Go\Session as Session;

/***********************************
* $date                       *
* Klevis Cipi                      * 
* cipiklevis@gmail.com             * 
*                                  * 
***********************************/

\n?>
<?php foreach (\$data['$postmodel'] as \$key => \$$thatmodel):?>";
foreach ($tablecolumns as $key => $value) {
$dataviews .= "\n<?php echo \$$thatmodel->$value->column_name ?>"; ;
}
$dataviews .= "
<?php endforeach ?>";

$dataview =
"<?php
use Go\Language as Language;
use Go\Media as Media;
use Go\Link as Link;
use Go\Session as Session;

/***********************************
* $date                       *
* Klevis Cipi                      * 
* cipiklevis@gmail.com             * 
*                                  * 
***********************************/

?>\n";
foreach ($tablecolumns as $key => $value) {
$dataview .= "\n<?php echo \$data['$thatmodel']->$value->column_name ?>";
}


				    touch($index);touch($add);touch($view);
				    chmod($index, 0777); chmod($add, 0777); chmod($view, 0777); 

				    $newFileViewIndex= fopen($index, 'w+');
					fwrite($newFileViewIndex, $dataviews);
					fclose($newFileViewIndex);

				    $newFileViewView= fopen($view, 'w+');
					fwrite($newFileViewView, $dataview);
					fclose($newFileViewView);

					$newFileViewAdd= fopen($add, 'w+');
					fwrite($newFileViewAdd, $dataview);
					fclose($newFileViewAdd);
				}
 

				if(!file_exists($filecontroller)){
				    touch($filecontroller);
				    chmod($filecontroller, 0777);
$datacontroller =
"<?php
namespace Go;
use Go\AppController as AppController;

/***********************************
* $date                       *
* Klevis Cipi                      * 
* cipiklevis@gmail.com             * 
*                                  * 
***********************************/

class $classController extends AppController
{

	public function index(){

	    \$data['title'] = 'Index';
	    \$data['headertitle'] = 'Index page';
	    \$data['content-title']='Index';
	    \$data['$postmodel']=\$this->Model->$postmodel();

		Template::View(\$this->Folder,'Index',\$data,\$error);
	}
	public function view(\$id){
		if(empty(\$id)){
			\$this->msg->error('Empty id or id don\'t exists', '/');
		}
	    \$data['title'] = 'View $thatmodel';
	    \$data['headertitle'] = 'View $thatmodel';
	    \$data['content-title']='View $thatmodel';
	    \$data['$thatmodel']=\$this->Model->$thatmodel(\$id)[0];

		Template::View(\$this->Folder,'View',\$data,\$error);
	}
	public function add(){

	    \$data['title'] = 'Add';
	    \$data['headertitle'] = 'Add page';
	    \$data['content-title']='Index';
	    \$post = \$_POST;
	   	\$$thatmodel=\$this->Model->add(\$post);
		Template::View(\$this->Folder,'Add',\$data,\$error);
	}

	public function edit(\$id=''){
		if(empty(\$id)){
			\$this->msg->error('Empty id or id don\'t exists', '/');
		}
		\$post = \$_POST;
	    \$data['title'] = 'Edit';
	    \$data['headertitle'] = 'Edit page';
	    \$data['content-title']='Edit';
	    \$$thatmodel=\$this->Model->update(\$id,\$post);
		Template::View(\$this->Folder,'Edit',\$data,\$error);
	}

	public function delete(\$id=''){
		if(empty(\$id)){
			\$this->msg->error('Empty id or id don\'t exists', '/');
		}
	    
	    \$delete = \$this->Model->delete(\$id);

	    if(\$delete){
	    	\$this->msg->success('Empty id or id don\'t exists', '/index');
	    }
	}

}";
					$newFileController= fopen($filecontroller, 'w+');
					fwrite($newFileController, $datacontroller);
					fclose($newFileController);
				}
				if(!file_exists($filemodel)){
				    touch($filemodel);
				    chmod($filemodel, 0777);				    
$datamodel .=
"<?php
namespace Go;
use Go\Connection as Connection;
use Go\AppModel as AppModel;

/***********************************
* $date                       *
* Klevis Cipi                      * 
* cipiklevis@gmail.com             * 
*                                  * 
***********************************/

class $classModel extends AppModel
{	
	private \$table = '$postmodel';

	public function $postmodel(){

	   \$sql = \$this->raw(\"SELECT * FROM \$this->table\");
		while (\$row = \$sql->fetch(\$this->obj)) {
			\$list[]=\$row;
		}
		return \$list;
	}
	public function $thatmodel(\$id){

	   \$sql = \$this->raw(\"SELECT * FROM \$this->table WHERE id = \$id\");
		while (\$row = \$sql->fetch(\$this->obj)) {
			\$list[]=\$row;
		}
		return \$list;
	}
	public function add(\$post){

		\$sql =\"INSERT INTO \$this->table (";
	foreach ($tablecolumns as $key => $value) {
	 unset($tablecolumns[0]);
	 $colum[] = $value->column_name;
	}
	$resultcolumn = implode(",",$colum);
	$resultcolumn_values = implode(",:",$colum);
	$datamodel .="$resultcolumn"; 
	$datamodel .=") VALUES(";
	$datamodel .="$resultcolumn_values";
	$datamodel .=")\";";
	$datamodel .="

		\$save=\$this->pdo->prepare(\$sql);";
	
	foreach ($tablecolumns as $key => $value) {
		$datamodel .="
		\$save->bindValue(':$value->column_name',strtolower(\$post['$value->column_name']));
		";
	}
	
	$datamodel .="	
		\$final  =\$save->execute();
		if(\$final){
			return true;
		}else return false;

	}
	public function delete(\$id){
		\$sql = \"DELETE FROM \$this->table WHERE id = \$id\";
		\$sql = \$this->pdo->prepare(\$sql);
		\$delete = \$sql->execute();
		if(\$delete){
			return true;
		}else return false;
	}

	public function update(\$id,\$post){
	";
	$datamodel .="
	\$sql =\"UPDATE \$this->table SET"; 
	foreach ($tablecolumns as $key => $value) {
		unset($tablecolumns[0]);
		$colum_conf[] = "$value->column_name = :$value->column_name";
    }
    $columnconf = implode(",",$colum_conf);
    $datamodel .="$columnconf";$datamodel .="  WHERE id=:id\";";
	$datamodel .="	
		\$save=\$this->pdo->prepare(\$sql);
	";
	foreach ($tablecolumns as $key => $value) {
		$datamodel .="
		\$save->bindValue(':$value->column_name',strtolower(\$post['$value->column_name']));
		";
	}
	$datamodel .="
		\$final  =\$save->execute();

		if(\$final){
			return true;
		}else return false;		
	}

}";
					$newFileModel= fopen($filemodel, 'w+');
					fwrite($newFileModel, $datamodel);
					fclose($newFileModel);
				}
				if(!file_exists($fileapicontroller)){
				    touch($fileapicontroller);
				    chmod($fileapicontroller, 0777);
$dataapicontroller =
"<?php
namespace Go;
use Go\ApiController as ApiController;

/***********************************
* $date                       *
* Klevis Cipi                      * 
* cipiklevis@gmail.com             * 
*                                  * 
***********************************/

class $classApiController extends ApiController
{

	public function index(){
		\$$postmodel = \$this->Model->$postmodel();

		if(empty(\$$postmodel)){
			\$response['data'] 	= '';
			\$response['error']	=1;
		}else{
			\$response['data'] 	= \$$postmodel;
			\$response['error']	=0;
		}
		
		\$this->json(\$response);
	}
	public function view(){
		\$id = \$_POST['id'];
		\$$thatmodel= \$this->Model->$thatmodel(\$id);

		if(empty(\$$thatmodel)){
			\$response['data'] 	= '';
			\$response['error']	=1;
		}else{
			\$response['data'] 	= \$$thatmodel;
			\$response['error']	=0;
		}
		
		\$this->json(\$response);
	}
	public function add(){
		\$post = \$_POST;
		\$add = \$this->Model->add(\$post);

		if(\$add){
			\$response['data'] 	= '';
			\$response['error']	=1;
		}else{
			\$response['data'] 	= \$add;
			\$response['error']	=0;
		}
		
		\$this->json(\$response);
	}
	public function delete(){

		\$id =\$_POST['id'];
		if(empty(\$id)){
			\$response['sms'] 	= 'Id is impty please check again!';
			\$response['error']	=1;		
		}else{
			\$delete = \$this->Model->delete(\$id);

			if(\$delete){
				\$response['sms'] 	= 'Item deletet successfully.';
				\$response['error']	=1;
			}else{
				\$response['sms'] 	= 'Item not deletet.';
				\$response['error']	= 0;
			}
		}

		
		\$this->json(\$response);
	}
}";
					$newFileApiController= fopen($fileapicontroller, 'w+');
					fwrite($newFileApiController, $dataapicontroller);
					fclose($newFileApiController);
				}
				if(!file_exists($fileapimodel)){
				    touch($fileapimodel);
				    chmod($fileapimodel, 0777);
$dataapimodel .=
"<?php
namespace Go;
use Go\ApiModel as ApiModel;

/***********************************
* $date                       *
* Klevis Cipi                      * 
* cipiklevis@gmail.com             * 
*                                  * 
***********************************/

class $classApiModel extends ApiModel
{	
	private \$table = '$postmodel';

	public function $postmodel(){

	   \$sql = \$this->raw(\"SELECT * FROM \$this->table\");
		while (\$row = \$sql->fetch(\$this->obj)) {
			\$list[]=\$row;
		}
		return \$list;
	}

	public function $thatmodel(\$id){

	   \$sql = \$this->raw(\"SELECT * FROM \$this->table WHERE id = \$id\");
		while (\$row = \$sql->fetch(\$this->obj)) {
			\$list[]=\$row;
		}
		return \$list;
	}

	public function add(\$post){

		\$sql =\"INSERT INTO \$this->table (";
	foreach ($tablecolumns as $key => $value) {
	 unset($tablecolumns[0]);
	 $colum[] = $value->column_name;
	}
	$resultcolumn = implode(",",$colum);
	$resultcolumn_values = implode(",:",$colum);
	$dataapimodel .="$resultcolumn"; 
	$dataapimodel .=") VALUES(";
	$dataapimodel .="$resultcolumn_values";
	$dataapimodel .=")\";";
	$dataapimodel .="

		\$save=\$this->pdo->prepare(\$sql);";
	
	foreach ($tablecolumns as $key => $value) {
		$dataapimodel .="
		\$save->bindValue(':$value->column_name',strtolower(\$post['$value->column_name']));
		";
	}
	
	$dataapimodel .="	
		\$final  =\$save->execute();
		if(\$final){
			return true;
		}else return false;

	}
	public function delete(\$id){
		\$sql = \"DELETE FROM \$this->table WHERE id = \$id\";
		\$sql = \$this->pdo->prepare(\$sql);
		\$delete = \$sql->execute();
		if(\$delete){
			return true;
		}else return false;
	}

	public function update(\$id,\$post){
	";
	$dataapimodel .="
	\$sql =\"UPDATE \$this->table SET "; 
	foreach ($tablecolumns as $key => $value) {
		unset($tablecolumns[0]);
		$colum_conf[] = "$value->column_name = :$value->column_name";
    }
    $columnconf = implode(",",$colum_conf);
    $dataapimodel .="$columnconf";$dataapimodel .="  WHERE id=:id\";";
	$dataapimodel .="	
		\$save=\$this->pdo->prepare(\$sql);
	";
	foreach ($tablecolumns as $key => $value) {
		$dataapimodel .="
		\$save->bindValue(':$value->column_name',strtolower(\$post['$value->column_name']));
		";
	}
	$dataapimodel .="
		\$final  =\$save->execute();

		if(\$final){
			return true;
		}else return false;		
	}

}";
					$newFileApiModel= fopen($fileapimodel, 'w+');
					fwrite($newFileApiModel, $dataapimodel);
					fclose($newFileApiModel);
				if(file_exists($filecontroller)
						&& file_exists($filemodel)
						&& file_exists($fileapicontroller)
						&& file_exists($fileapimodel)
						&& file_exists($index)
						&& file_exists($add)
						&& file_exists($edit) ){
				    return true;

				}else{
					return true;
				}
		}
		
		} //DBTYPE


	}//FUNCTION 

}//CLASS