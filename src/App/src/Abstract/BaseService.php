<?php

namespace App\Abstract;

use App\Exception\NotFoundException;
use App\Utils\Merger;
use AutoMapperPlus\AutoMapper;

/**
 * Abstract class BaseService.
 *
 * This class provides an abstraction for service classes in the application.
 * It offers methods for common operations such as fetching, creating,
 * deleting, and editing entities using a repository and a mapper.
 */
abstract class BaseService
{
    protected BaseRepository $repository;

    protected AutoMapper $mapper;

    /**
     * Retrieves the current mapper instance.
     *
     * @return AutoMapper The current AutoMapper instance.
     */
    public function getMapper(): AutoMapper
    {
        return $this->mapper;
    }

    /**
     * Sets the mapper instance.
     *
     * @param AutoMapper $mapper The mapper instance to set.
     *
     * @return void
     */
    public function setMapper(AutoMapper $mapper): void
    {
        $this->mapper = $mapper;
    }

    /**
     * Retrieves an entity by its unique identifier (ID).
     *
     * @param string $id The unique identifier of the entity.
     *
     * @return mixed The entity corresponding to the provided ID.
     *
     * @throws NotFoundException If no entity is found with the provided ID.
     */
    public function getById(string $id)
    {
        $result = $this->repository->getById($id);

        if ($result === null) {
            throw new NotFoundException();
        }

        return $result;
    }

    /**
     * Retrieves all entities from the repository.
     *
     * @return array An array of all entities.
     */
    public function getAll(): array
    {
        return $this->repository->getAll();
    }

    /**
     * Creates a new entity based on the provided request data.
     *
     * @param mixed $request The data to create the new entity.
     *
     * @return mixed The created entity.
     */
    public function create($request)
    {
        $obj = $this->mapper->map($request, $this->repository->getEntityClass());
        return $this->repository->createOne($obj);
    }

    /**
     * Deletes an entity by its unique identifier (ID).
     *
     * @param string $id The unique identifier of the entity to delete.
     *
     * @return mixed The deleted entity.
     *
     * @throws NotFoundException If no entity is found with the provided ID.
     */
    public function delete(string $id)
    {
        $obj = $this->repository->getById($id);

        if ($obj === null) {
            throw new NotFoundException();
        }

        $this->repository->deleteOne($obj);
        return $obj;
    }

    /**
     * Edits (updates) an existing entity by its ID with the provided request data.
     *
     * @param string $id The unique identifier of the entity to edit.
     * @param mixed $request The data to update the entity.
     * @param bool $replace Indicates whether to replace existing properties or merge them (default is false).
     *
     * @return mixed The updated entity.
     *
     * @throws NotFoundException If no entity is found with the provided ID.
     */
    public function edit(string $id, $request, bool $replace = false)
    {
        $oldObj = $this->repository->getById($id);

        if ($oldObj === null) {
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
