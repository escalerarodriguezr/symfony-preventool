<?php
declare(strict_types=1);

namespace Preventool\Domain\OccupationalRisk\Model\Value;

use Assert\Assertion;
use Assert\AssertionFailedException;

class SeverityIndex
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
            1 => 'Lesión sin incapacidad (S) / Disconfort o Incomodidad (SO)',
            2 => 'Lesión con incapacidad temporal (S) / Daño a la salud reversible (SO)',
            3 => 'Lesión con incapacidad permanente (S) / Daño a la salid irreversible (SO)',
            default => '',
        };
    }

}