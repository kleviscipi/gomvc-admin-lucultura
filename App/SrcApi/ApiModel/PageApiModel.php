<?php
namespace Go;

use Go\ApiModel as ApiModel;

/**
* klevis cipi
*/
class PageApiModel extends ApiModel
{	

	public function persons(){

		$sql = $this->raw("SELECT * FROM persons");
		$persons=[];

		while ($row = $sql->fetch($this->obj)) {
			$persons[]=$row;
		}

		return $persons;
	}
}