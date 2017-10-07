<?php 
namespace Go;
/**
* klevis cipi 2016 cipiklevis@gmail.com
*/
class DataApiModel
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
	public function schema($table_name)
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
		
		$user 		= Session::get('name');
		$id 		= Session::get('iduser');
		$controller = strtolower($GLOBALS['controller']);
		$method 	= strtolower($GLOBALS['method']);

		if( !empty( $id ) && !empty( $user ) ){
			$permited =$this->raw(" SELECT count(*) FROM permisions as p inner join user_permisions as up on(p.id = up.permision_id ) inner join role_permisions as rp on(rp.role_id = up.role_id AND rp.permision_id = up.permision_id) where up.user_id = $id AND up.permited = true AND rp.permited = true AND lower(p.controller) = lower('$controller') AND lower(p.method) = lower('$method')");
			while ($row = $schema->fetch($this->obj)) {
				$permited['permited']=$permited;
			}
			return (object) $permited;
		}

	}


}