<?php

namespace App\Abstract;

use Cycle\ORM\Select\Repository;
use Cycle\Schema\Definition\Entity;
use Cycle\ORM\EntityManager;

class BasicRepository extends Repository {

    private EntityManager $entityManager;

    public function setEntityManager($entityManager)
    {
        $this->entityManager = $entityManager;
    }

	public function getFirst() : ?Entity {
		return $this->select()->orderBy('created_at')->limit(1)->fetchOne();
	}

	public function getLast() : ?Entity {
		return $this->select()->orderBy('created_at', 'DESC')->limit(1)->fetchOne();
	}

    public function findById($id)
    {
        $user = $this->select()->where(['id' => $id])->fetchOne();
        return $user;
    }

    public function fetchAll()
    {
        $users = $this->select()->findAll();
        return $users;
    }

    public function createOne($objRequest)
    {
        $user = $this->entityManager->persist($objRequest);
        $this->entityManager->run();

        return $user;
    }
}
