<?php
namespace Go;

/**
* klevis cipi
*/
class Connection
{
	
	private static $conn;

	public function connect(){

		if(DB_TYPE =='MYSQL'){
			$params = parse_ini_file('_data/_db/DatabaseMysql.ini');

				if($params === false){
					throw new \Exception("ERRORE GENERETING FILE DATABASE INI");
				}

				$host 	= $params['host'];
				$dbname = $params['database'];
				$user 	= $params['user'];
				$pass 	= $params['password'];
				
				$pdo = new \PDO("mysql:host=$host;dbname=$dbname",$user,$pass);

				$pdo->setAttribute(\PDO::ATTR_ERRMODE,\PDO::ERRMODE_EXCEPTION);
				return $pdo;
		}else if(DB_TYPE == 'POSTGRES'){
			$params = parse_ini_file('_data/_db/DatabasePostgres.ini');
				if($params === false){
					throw new \Exception("ERRORE GENERETING FILE DATABASE INI");
					
				}
				$conStr= sprintf("pgsql:host=%s;port=%d;dbname=%s;user=%s;password=%s",
					$params['host'],
					$params['port'],
					$params['database'],
					$params['user'],
					$params['password']

					);
				$pdo = new \PDO($conStr);
				$pdo->setAttribute(\PDO::ATTR_ERRMODE,\PDO::ERRMODE_EXCEPTION);
				return $pdo;

		}


	}
	public static function get(){

		if(null===static::$conn){

			static::$conn=new static();
		}
		return static::$conn;
	}

	public function __construct(){}
	public function __clone(){}
	public function __wakeup(){}

}