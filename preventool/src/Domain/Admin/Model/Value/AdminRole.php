<?php
declare(strict_types=1);

namespace Preventool\Domain\Admin\Model\Value;

use Assert\Assertion;
use Assert\AssertionFailedException;

class AdminRole
{
    const ADMIN_ROLE_ROOT = 'ROOT';
    const ADMIN_ROLE_ADMIN = 'ADMIN';

    const VALID_TYPES = [
        self::ADMIN_ROLE_ROOT,
        self::ADMIN_ROLE_ADMIN
    ];


    public function __construct(
        public readonly string $value
    )
    {
        try {
            Assertion::choice($value, self::VALID_TYPES);
        } catch(AssertionFailedException $e) {
            throw new \DomainException(sprintf('"%s" is an invalid Admin Role', $value));
        }

    }
}