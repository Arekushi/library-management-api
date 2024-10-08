<?php

namespace App\Aspect;

use App\Abstract\BasicHandler;
use App\Exception\InvalidJsonBodyException;
use App\Utils\HydratorMapper;
use Attribute;
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
        $request = $invocation->getArgument(0);

        $route = $subject->getRoute($request);

        if (isset($route['requestClass']) && $route['requestClass'] !== null)
        {
            $requestClass = $route['requestClass'];
            $data = $request->getParsedBody();
            $request = HydratorMapper::map($data, $requestClass);

            $validator = Validation::createValidatorBuilder()
                ->enableAttributeMapping()
                ->getValidator();

            $violations = $validator->validate($request);

            if (count($violations) > 0)
            {
                throw new InvalidJsonBodyException($violations);
            }
        }
    }
}