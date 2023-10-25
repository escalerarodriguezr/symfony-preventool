<?php
declare(strict_types=1);

namespace Preventool\Domain\Shared\Model\Value;

use Assert\Assertion;
use Assert\AssertionFailedException;

class DocumentStatus
{
    const PENDING = 'PENDING';
    const DRAFT = 'DRAFT';

    const REVIEWED = 'REVIEWED';

    const APPROVED = 'APPROVED';

    const VALID_OPTIONS = [
        self::PENDING,
        self::DRAFT,
        self::REVIEWED,
        self::APPROVED
    ];

    public function __construct(
        public readonly string $value
    )
    {
        try {
            Assertion::choice($value, self::VALID_OPTIONS);
        } catch(AssertionFailedException $e) {
            throw new \DomainException(sprintf('"%s" is an invalid Status', $value));
        }

    }

}