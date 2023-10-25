<?php
declare(strict_types=1);

namespace Preventool\Domain\Admin\Model\Value;

use Assert\Assertion;
use Assert\AssertionFailedException;
use Preventool\Domain\User\Model\Value\UserRole;

class AdminType
{
    const ADMIN_TYPE_ADMIN = UserRole::USER_ROLE_ADMIN;
    const ADMIN_TYPE_EMPLOYEE = UserRole::USER_ROLE_EMPLOYEE;


    const VALID_TYPES = [
        self::ADMIN_TYPE_ADMIN,
        self::ADMIN_TYPE_EMPLOYEE
    ];


    public function __construct(
        public readonly string $value
    )
    {
        try {
            Assertion::choice($value, self::VALID_TYPES);
        } catch(AssertionFailedException $e) {
            throw new \DomainException(sprintf('"%s" is an invalid type', $value));
        }

    }
}