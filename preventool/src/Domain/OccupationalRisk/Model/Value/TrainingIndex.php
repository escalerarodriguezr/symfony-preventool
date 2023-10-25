<?php
declare(strict_types=1);

namespace Preventool\Domain\OccupationalRisk\Model\Value;

use Assert\Assertion;
use Assert\AssertionFailedException;

class TrainingIndex
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
            1 => 'Personal entrenado. Conoce el peligro y lo previene',
            2 => 'Personal parcialmente entrenado. Conoce el peligro pero no toma acciones de control',
            3 => 'Personal no entrenado. No conoce el peligro y no toma acciones de control',
            default => '',
        };
    }

}