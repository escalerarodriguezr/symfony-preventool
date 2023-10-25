<?php
declare(strict_types=1);

namespace Preventool\Domain\Shared\Model\Value;

use Assert\Assertion;
use Assert\AssertionFailedException;

class CompliancePercentage
{

    public function __construct(
        public readonly int $value
    )
    {
        try {
            Assertion::integer($value);
            Assertion::between($value, 0, 100);
        } catch(AssertionFailedException $e) {
            throw new \DomainException(sprintf('"Value %d must be integer between 0 and 100', $value));
        }

    }

}