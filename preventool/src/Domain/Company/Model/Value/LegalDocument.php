<?php

namespace Preventool\Domain\Company\Model\Value;

use Assert\Assertion;
use Assert\AssertionFailedException;

class LegalDocument
{
    public function __construct(
        public readonly string $value
    )
    {
        try {
            Assertion::maxLength($value, 20);
        } catch(AssertionFailedException $e) {
            throw new \DomainException(sprintf('"%s" must be %d characters maximum', $value, 20));
        }

    }

}