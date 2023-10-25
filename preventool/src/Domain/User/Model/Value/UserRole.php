<?php
declare(strict_types=1);

namespace Preventool\Domain\User\Model\Value;

use Assert\Assertion;
use Assert\AssertionFailedException;

class UserRole
{
    const USER_ROLE_ADMIN = 'ADMIN';
    const USER_ROLE_EMPLOYEE = 'EMPLOYEE';

    const VALID_ROLES = [
        self::USER_ROLE_ADMIN,
        self::USER_ROLE_EMPLOYEE
    ];

    public function __construct(
        public readonly string $value
    )
    {

        try {
            Assertion::choice($value, self::VALID_ROLES);
        } catch(AssertionFailedException $e) {
            throw new \DomainException(sprintf('"%s" is an invalid role', $value));
        }

    }
}