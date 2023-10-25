<?php
declare(strict_types=1);

namespace Preventool\Domain\OccupationalRisk\Model\Value;

use Assert\Assertion;
use Assert\AssertionFailedException;

class ExposureIndex
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
            1 => 'Al menos una vez al año (S) / Esporádicamente (SO)',
            2 => 'Al menos una vez al mes (S) / Eventualmente (SO)',
            3 => 'Al menos una vez al día (S) / Permanentemente (SO)',
            default => '',
        };
    }




}