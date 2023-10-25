<?php
declare(strict_types=1);

namespace Preventool\Domain\Audit\Model\Value;

use Assert\Assertion;
use Assert\AssertionFailedException;
use Preventool\Domain\User\Model\Value\UserRole;

class AuditTypeScope
{
    const SCOPE_SYSTEM  = 'SYSTEM';
    const SCOPE_COMPANY  = 'COMPANY';
    const SCOPE_WORKPLACE  = 'WORKPLACE';



    const VALID_SCOPES = [
        self::SCOPE_SYSTEM,
        self::SCOPE_COMPANY,
        self::SCOPE_WORKPLACE
    ];


    public function __construct(
        public readonly string $value
    )
    {
        try {
            Assertion::choice($value, self::VALID_SCOPES);
        } catch(AssertionFailedException $e) {
            throw new \DomainException(sprintf('"%s" is an invalid scope', $value));
        }

    }
}