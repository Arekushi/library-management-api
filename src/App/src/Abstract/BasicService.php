<?php

namespace App\Abstract;

use App\Exception\NotFoundException;
use App\Utils\HydratorMapper;
use Laminas\Hydrator\ClassMethodsHydrator;

abstract class BasicService
{
    protected BasicRepository $repository;

    public function getById($id)
    {
        $result = $this->repository->getById($id);

        if ($result == null)
        {
            throw new NotFoundException();
        }

        return $result;
    }

    public function getAll()
    {
        return $this->repository->getAll();
    }

    public function create($request)
    {
        $obj = HydratorMapper::map(
            $request,
            $this->repository->getEntityClass(),
            ClassMethodsHydrator::class
        );

        return $this->repository->createOne($obj);
    }

    public function delete($id)
    {
        $obj = $this->repository->getById($id);

        if ($obj == null)
        {
            throw new NotFoundException();
        }

        $this->repository->deleteOne($obj);
        return $obj;
    }

    public function edit($id, $request)
    {
        $oldObj = $this->repository->getById($id);

        if ($oldObj == null)
        {
            throw new NotFoundException();
        }

        $newObj = HydratorMapper::merge($oldObj, $request);
        $this->repository->editOne($newObj);

        return $newObj;
    }
}
