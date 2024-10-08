<?php

namespace App\Aspect;

use App\Abstract\BaseHandler;
use App\Exception\InvalidJsonBodyException;
use Attribute;
use Okapi\Aop\Invocation\BeforeMethodInvocation;
use Okapi\Aop\Attributes\Aspect;
use Okapi\Aop\Attributes\Before;
use Symfony\Component\Validator\Validation;

/**
 * Aspect for validating JSON body of incoming requests.
 *
 * This class is an aspect that validates the JSON body of incoming requests
 * based on the expected request class defined in the route configuration.
 *
 * When a request is received, it maps the incoming data to the respective
 * request class and validates it using Symfony's Validator component,
 * which supports attribute-based validation. If any validation errors are
 * found, an `InvalidJsonBodyException` is thrown, halting the request processing.
 *
 * @Attribute
 * @Aspect
 */
#[Attribute]
#[Aspect]
class JsonBodyValidatorAspect
{
    public function __construct()
    {
    }

    #[Before]
    public function validate(BeforeMethodInvocation $invocation)
    {
        /** @var BaseHandler $subject */
        $subject = $invocation->getSubject();
        $request = $invocation->getArgument(0);

        $route = $subject->getRoute($request);

        if ($route->getRequestClass() !== null) {
            $requestClass = $route->getRequestClass();
            $data = $request->getParsedBody();
            $mapper = $subject->getMapper();
            $request = $mapper->map($data, $requestClass);

            $validator = Validation::createValidatorBuilder()
                ->enableAttributeMapping()
                ->getValidator();

            $violations = $validator->validate($request);

            if (count($violations) > 0) {
                throw new InvalidJsonBodyException($violations);
            }
        }
    }
}
