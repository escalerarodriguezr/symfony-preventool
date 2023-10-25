<?php
declare(strict_types=1);

namespace Preventool\Domain\OccupationalRisk\Model\Value;

use Assert\Assertion;
use Assert\AssertionFailedException;

class ProcedureIndex
{

    public function __construct(
        public readonly int $value
    )
    {
        try {
            Assertion::integer($value);
            Assertion::between($value, 1, 3);
        } catch(AssertionFailedException $e) {
            throw new \DomainException(sprintf('"Value %d must be integer between 1 and 3', $value));
        }

    }

    public function description():string{
        return match ($this->value) {
            1 => 'Existen, son satisfactorios y suficientes',
            2 => 'Existen, parcialmente y no son satisfactorios o suficientes',
            3 => 'No existen',
            default => '',
        };
    }

}