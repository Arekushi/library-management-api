<?php

namespace App\Aspect;

use App\Abstract\BasicHandler;
use App\Exception\InvalidJsonBodyException;
use Attribute;
use Laminas\Hydrator\ReflectionHydrator;
use Mezzio\Router\RouteResult;
use Okapi\Aop\Invocation\BeforeMethodInvocation;
use Okapi\Aop\Attributes\Aspect;
use Okapi\Aop\Attributes\Before;
use Symfony\Component\Validator\Validation;

#[Attribute]
#[Aspect]
class JsonBodyValidatorAspect
{
    #[Before]
    public function validate(BeforeMethodInvocation $invocation)
    {
        /** @var BasicHandler $subject */
        $subject = $invocation->getSubject();

        $routes = $subject->getRoutes();
        $request = $invocation->getArgument(0);

        $routeResult = $request->getAttribute(RouteResult::class);
        $routeName = $routeResult->getMatchedRouteName();
        $route = $routes[$routeName];

        if (isset($route['requestClass']) && $route['requestClass'] !== null)
        {
            $requestClass = $route['requestClass'];
            $data = $request->getParsedBody();
            $requestClassInstance = new $requestClass();
            $hydrator = new ReflectionHydrator();
            $hydrator->hydrate($data, $requestClassInstance);

            $validator = Validation::createValidatorBuilder()
                ->enableAttributeMapping()
                ->getValidator();

            $violations = $validator->validate($requestClassInstance);

            if (count($violations) > 0)
            {
                throw new InvalidJsonBodyException($violations);
            }
        }
    }
}
