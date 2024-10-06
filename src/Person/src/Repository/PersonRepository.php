<?php

namespace Person\Repository;

use App\Abstract\BasicRepository;

class PersonRepository extends BasicRepository
{
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
}
