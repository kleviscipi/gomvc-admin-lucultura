<?php 
namespace Go;
use Go\Connection as Connection;
use Go\DataModel as DataModel;
/*
klevis cipi 2016 cipiklevis@gmail.com
**/
class AppModel extends DataModel
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

}