<?php
declare(strict_types=1);

namespace Preventool\Domain\OccupationalRisk\Model\Value;

use Assert\Assertion;
use Assert\AssertionFailedException;

class PeopleExposedIndex
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
            1 => 'De 1 a 3',
            2 => 'De 4 a 12',
            3 => 'Más de 12',
            default => '',
        };
    }

}