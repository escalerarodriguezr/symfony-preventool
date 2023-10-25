<?php
declare(strict_types=1);

namespace Preventool\Domain\BaselineStudy\Model\Value;

use Assert\Assertion;
use Assert\AssertionFailedException;
use Preventool\Domain\User\Model\Value\UserRole;

class BaselineIndicatorCategory
{
    const CATEGORY_COMPROMISO = 'compromiso';
    const CATEGORY_POLITICA = 'politica';
    const CATEGORY_PLANEAMIENTO = 'planeamiento';
    const CATEGORY_IMPLEMENTACION = 'implementacion';
    const CATEGORY_EVALUACION = 'evaluacion';
    const CATEGORY_VERIFICACION = 'verificacion';
    const CATEGORY_CONTROL = 'control';
    const CATEGORY_REVISION = 'revision';




    const VALID_SCOPES = [
        self::CATEGORY_COMPROMISO,
        self::CATEGORY_POLITICA,
        self::CATEGORY_PLANEAMIENTO,
        self::CATEGORY_IMPLEMENTACION,
        self::CATEGORY_EVALUACION,
        self::CATEGORY_VERIFICACION,
        self::CATEGORY_CONTROL,
        self::CATEGORY_REVISION,

    ];


    public function __construct(
        public readonly string $value
    )
    {
        try {
            Assertion::choice($value, self::VALID_SCOPES);
        } catch(AssertionFailedException $e) {
            throw new \DomainException(sprintf('"%s" is an invalid category', $value));
        }

    }
}