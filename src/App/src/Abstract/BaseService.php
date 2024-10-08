<?php

namespace App\Abstract;

use App\Exception\NotFoundException;
use App\Utils\HydratorMapper;
use App\Utils\Merger;
use Laminas\Hydrator\ClassMethodsHydrator;

abstract class BaseService
{
    protected BaseRepository $repository;

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

    public function edit($id, $request, $replace = false)
    {
        $oldObj = $this->repository->getById($id);

        if ($oldObj == null)
        {
            throw new NotFoundException();
        }

        $newObj = Merger::merge(
            $oldObj,
            $request,
            ignoreProperties: ['uuid'],
            replace: $replace
        );

        $this->repository->editOne($newObj);
        return $newObj;
    }
}
