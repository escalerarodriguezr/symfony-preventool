<?php
declare(strict_types=1);

namespace Preventool\Domain\User\Model\Value;

use Assert\Assertion;
use Assert\AssertionFailedException;

class UserPassword
{

    public function __construct(
        public readonly string $value
    )
    {
        try {
            Assertion::minLength($value, 6);
        } catch(AssertionFailedException $e) {
            throw new \DomainException(sprintf('"%s" is an invalid password', $value));
        }
    }
}