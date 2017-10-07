<?php 
namespace Go;
use Go\Session as Session;
use Go\Ip as Ip;
/**
* klevis cipi 2016 cipiklevis@gmail.com
*/
class DataModel
{

	
	public function key()
	{
		$key = $this->raw("SELECT * FROM gokeys");

		while ($rowkey = $key->fetch()) {
			$thatkey['keysite'] = $rowkey['thatkey'];
		}
		$keyapi = $this->raw("SELECT * FROM gokeys WHERE type = 'api'");
		while ($row  =  $keyapi->fetch()) {
			$thatkey['keyapi'] = $row['thatkey'];
		}
		$password = $this->raw("SELECT * FROM gokeys WHERE type = 'password'");
		while ($row  =  $password->fetch()) {
			$thatkey['password'] = $row['thatkey'];
		}
		return (object) $thatkey;
	}

	public function schema($table_name="")
	{

		$schema = $this->raw("SELECT table_name
								 FROM information_schema.tables
									WHERE table_schema ='public' AND table_type = 'BASE TABLE'
										ORDER BY table_name" );
		while ( $row = $schema->fetch( $this->obj ) ) {
			$schemas['schema'][]=$row;
		}

		if(!empty($table_name)){
			$table_name = strtolower($table_name);
			$columns = $this->raw("SELECT column_name FROM information_schema.columns WHERE lower(table_name) = lower('$table_name') ");
			while ( $row = $columns->fetch( $this->obj ) ) {
				$schemas['columns'][]=$row;
			}
		}

		return (object) $schemas;
	}

	public function is_permited(){

		$controller = strtolower($GLOBALS['class']);
		$method 	= strtolower($GLOBALS['method']);
		if(!empty( $this->is_start()->id ) && !empty( $this->is_start()->user ) ){
			$permited =$this->raw("SELECT count(*) FROM permisions AS p INNER JOIN user_permisions as up ON(p.id = up.permision_id ) INNER JOIN role_permisions AS rp ON(rp.role_id = up.role_id AND rp.permision_id = up.permision_id) WHERE up.permited = true AND rp.permited = true AND lower(p.controller) = lower('$controller') AND lower(p.method) = lower('$method') AND up.user_id =  ".$this->is_start()->id." ");
			$permessi=[];
			while ($row = $permited->fetch($this->obj)) {
				$permessi['permited']=$row;
			}
			return (object) $permessi;
		}

	}
	public function menu(){

		if(!empty($this->is_start()->id)){
			$menu =$this->raw("SELECT p.controller,p.method,up.permited,rp.permited FROM permisions as p inner join user_permisions as up on(p.id = up.permision_id   ) left join role_permisions as rp on(rp.role_id = up.role_id  ) where  up.user_id = ".$this->is_start()->id." AND up.permited = true AND rp.permited = true  AND p.sublink = false GROUP BY p.controller,p.method,up.permited,rp.permited ;");

			while ($row = $menu->fetch($this->obj)) {
				$menus['li'][]=$row;
			}
			$frommenu =$this->raw("SELECT DISTINCT p.controller, count(DISTINCT  up.permision_id) FROM permisions as p inner join user_permisions as up on(p.id = up.permision_id ) inner join role_permisions as rp on(rp.role_id = up.role_id) where up.user_id = ".$this->is_start()->id." AND up.permited = true AND rp.permited = true and p.sublink = false GROUP BY p.controller");
			while ($row = $frommenu->fetch($this->obj)) {
				$menus['ul'][]=$row;
			}
			return (object) $menus;
		}

	}

	public function is_start(){
		$start = [];
		$start['id'] 		= Session::get('iduser');
		$start['user'] 		= Session::get('username');
		$start['email'] 	= Session::get('email');
		$start['name'] 	    = Session::get('name');
		return (Object) $start;
	}

	public function ifblocket(){
		$ip      = Ip::getIp();
		$ifblocket = $this->ifipblock($ip);
		if($ifblocket['ip']->count > 0){
			return true;
		}else{
			return false;
		}
	}
	public function ifipblock($ip){
		$ips = $this->raw("SELECT count(*) FROM visits WHERE lower(ip) = lower('$ip') AND state ='f'");
	  	while ($row = $ips->fetch($this->obj)) { $list['ip']=$row; } return $list;
	}
}