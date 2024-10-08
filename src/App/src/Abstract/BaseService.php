<?php

namespace App\Abstract;

use App\Exception\NotFoundException;
use App\Utils\Merger;
use AutoMapperPlus\AutoMapper;
use Laminas\Hydrator\ClassMethodsHydrator;

abstract class BaseService
{
    protected BaseRepository $repository;

    protected AutoMapper $mapper;

    public function getMapper()
    {
        return $this->mapper;
    }

    public function setMapper($mapper)
    {
        $this->mapper = $mapper;
    }

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
        $obj = $this->mapper->map($request, $this->repository->getEntityClass());
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
            mapper: $this->mapper,
            ignoreProperties: ['uuid'],
            replace: $replace
        );

        $this->repository->editOne($newObj);
        return $newObj;
    }
}
