<?php

declare(strict_types=1);

namespace Person\Handler;

use App\InputFilter\CreatePersonInputFilter;
use Person\Request\CreatePersonRequest;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Laminas\Diactoros\Response\JsonResponse;
use Mezzio\Router\RouteResult;
use Person\Service\PersonService;
use Symfony\Component\Validator\Validation;

class PersonHandler implements RequestHandlerInterface
{
    protected $routes;

    protected $personService;

    public function __construct(PersonService $personService)
    {
        $this->personService = $personService;
        $this->routes = [
            'person.get' => [$this, 'getPerson'],
            'person.create' => [$this, 'createPerson']
        ];
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $routeResult = $request->getAttribute(RouteResult::class);
        $routeName = $routeResult->getMatchedRouteName();
        return call_user_func($this->routes[$routeName], $request);
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
    public function getPerson(ServerRequestInterface $request)
    {
        $id = $request->getAttribute('id');
        $user = $this->personService->getPerson($id);

        $message = 'sim';

        if ($user == null) {
            $message = 'nao';
        }

        return new JsonResponse(
            ['message' => $message]
        );
    }

    public function createPerson(ServerRequestInterface $request)
    {
        $data = $request->getParsedBody();
        $person = new CreatePersonRequest($data['name'],  $data['email']);

        $validator = Validation::createValidatorBuilder()
            ->enableAttributeMapping()
            ->getValidator();

        $violations = $validator->validate($person);
        $message = 'sim';

        if (count($violations) > 0)
        {
            $message = 'nao';
        }

        return new JsonResponse(['message' => $message]);
    }
}
