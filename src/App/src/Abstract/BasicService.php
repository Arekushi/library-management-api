<?php

namespace App\Abstract;

class BasicService
{
    protected BasicRepository $repository;

    public function get($id)
    {
        return $this->repository->findById($id);
    }

    public function getAll()
    {
        return $this->repository->fetchAll();
    }

    public function create($request) {
        return $this->repository->createOne($request);
    }
}
