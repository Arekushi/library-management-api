<?php

namespace App\Abstract;

use Cycle\ORM\Select\Repository;
use Cycle\Schema\Definition\Entity;

class BasicRepository extends Repository {

	public function getFirst() : ?Entity {
		return $this->select()->orderBy('created_at')->limit(1)->fetchOne();
	}

	public function getLast() : ?Entity {
		return $this->select()->orderBy('created_at', 'DESC')->limit(1)->fetchOne();
	}
}
