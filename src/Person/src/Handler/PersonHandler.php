<?php

declare(strict_types=1);

namespace Person\Handler;

use App\Abstract\BasicHandler;
use Person\Request\CreatePersonRequest;
use Person\Request\EditPersonRequest;
use Person\Response\GetPersonResponse;
use Person\Service\PersonService;

class PersonHandler extends BasicHandler
{
    public function __construct(PersonService $personService)
    {
        $this->service = $personService;
        $this->routes = [
            'person.get' => [
                'callback' => [$this, 'get'],
                'responseClass' => GetPersonResponse::class
            ],
            'person.list' => [
                'callback' => [$this, 'list'],
                'responseClass' => GetPersonResponse::class
            ],
            'person.create' => [
                'callback' => [$this, 'create'],
                'requestClass' => CreatePersonRequest::class,
                'responseClass' => GetPersonResponse::class
            ],
            'person.delete' => [
                'callback' => [$this, 'delete']
            ],
            'person.edit' => [
                'callback' => [$this, 'edit'],
                'requestClass' => EditPersonRequest::class,
                'responseClass' => GetPersonResponse::class
            ]
        ];
    }

    /**
     * @OA\Get(path="/person/{id}",
     *   summary="Obter informações de uma pessoa",
     *   tags={"Person"},
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     required=true,
     *     @OA\Schema(
     *       type="string"
     *     )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Returns Person object",
     *     @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(ref="#/components/schemas/Person"),
     *     ),
     *   ),
     *   @OA\Response(
     *     response=404,
     *     description="Person not found"
     *   )
     * )
     */
}
