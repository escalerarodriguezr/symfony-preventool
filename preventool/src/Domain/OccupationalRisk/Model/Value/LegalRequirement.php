<?php
declare(strict_types=1);

namespace Preventool\Domain\OccupationalRisk\Model\Value;

use Assert\Assertion;
use Assert\AssertionFailedException;

class LegalRequirement
{
    public function __construct(
        public readonly string $value
    )
    {
        try {
            Assertion::maxLength($value, 300);
        } catch(AssertionFailedException $e) {
            throw new \DomainException(sprintf('"%s" must be %d characters maximum', $value, 300));
        }

    }

}