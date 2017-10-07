<?php 
namespace Go;

use Go\Connection as Connection;
use Go\DataApiModel as DataApiModel;
use Go\Session as Session;
class ApiModel extends DataApiModel
{
	public  $pdo;
	public  $obj;
	public  $arr;
	public  $ints;


	public function __construct()
	{
		$this->pdo 	=$this->PDO();
		$this->obj 	=$this::obj();
		$this->arr 	=$this::arr();
		$this->ints =$this::ints();

	}
	public function PDO()
	{
		return Connection::get()->connect();

	}
	
	public  function raw($sql){
		return $this->pdo->query($sql);
	}
	public  function inserted($sql){
		return $this->pdo->prepare($sql);
	}
	public static  function obj()
	{
		return \PDO::FETCH_OBJ;
	}

	public static  function arr()
	{
		return \PDO::FETCH_ASSOC;
	}

	public static  function ints()
	{
		return \PDO::PARAM_INT;
	}
	public function insertactions($action,$controller,$description,$user,$count){
		if(Session::get('superuser'=="t")){
			return true;
		}else{
			$save = $this->inserted("INSERT INTO actions (action,controller,description,user_id,counts) VALUES (:action,:controller,:description,:user_id,:counts)");
			$save->bindValue(':action',$action);
			$save->bindValue(':controller',	$controller);
			$save->bindValue(':description',$description);
			$save->bindValue(':user_id',$user);
			$save->bindValue(':counts',$count);
			$final  =$save->execute();
			if($final){
				return true;
			}else return false;			
		}

	}
	public function access($ip,$username,$email,$userid,$action = false){
		$save = $this->inserted("INSERT INTO access (ip,username,email,user_id,action) VALUES (:ip,:username,:email,:user_id,:action)");
		$save->bindValue(':action',$action);
		$save->bindValue(':ip',	$ip);
		$save->bindValue(':email',$email);
		$save->bindValue(':user_id',$userid);
		$save->bindValue(':username',$username);
		$final  =$save->execute();
		if($final){
			return true;
		}else return false;
	}

}