<?php
declare(strict_types=1);

namespace Preventool\Infrastructure\Ui\Http\Service\IdentityValidator;

use Preventool\Domain\Shared\Model\IdentityValidator;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Validator\Constraints\Uuid;
use Symfony\Component\Validator\Validation;

final class HttpIdentityValidator implements IdentityValidator
{
    public function validate(string $id): void
    {
        $validator = Validation::createValidator();

        $uuidConstraint = new Uuid();
        $uuidConstraint->message = sprintf("%s has invalid Uuid format",$id);

        $errors = $validator->validate(
            $id,
            $uuidConstraint
        );

        if (count($errors))
        {
            throw new BadRequestHttpException( $uuidConstraint->message);
        }
    }


}