<?php

namespace Go;
use Go\Connection as Connection;
use Go\AppModel as AppModel;

/**
* klevis cipi
*/
class PageModel extends AppModel
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