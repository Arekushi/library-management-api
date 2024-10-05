<?php

namespace People\Repository;

use App\Abstract\BasicRepository;

class PeopleRepository extends BasicRepository
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
