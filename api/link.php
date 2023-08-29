<?php

// link.php

// Class for managing links


class LINK {

	private $parentId;
	private $childId;
	private $table = 'links';

	function __construct($parentId = 0, $childId = 0) {
		$this->parentId = $parentId;
		$this->childId = $childId;
	}

	function save(VCRUD $c) {
		$c->create($this->table,['parentId'=>$this->parentId,'childId'=>$this->childId]);
	}
}
