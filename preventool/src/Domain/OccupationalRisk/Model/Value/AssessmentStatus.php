<?php
declare(strict_types=1);

namespace Preventool\Domain\OccupationalRisk\Model\Value;

use Assert\Assertion;
use Assert\AssertionFailedException;

class AssessmentStatus
{

    const DRAFT = 'DRAFT';
    const REVISED = 'REVISED';
    const APPROVED = 'APPROVED';

    const VALID_OPTIONS = [
        self::DRAFT,
        self::REVISED,
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

    public function description():string{
        return match ($this->value) {
            self::DRAFT => 'Borrador',
            self::REVISED => 'Revisado',
            self::APPROVED => 'Aprobado',
            default => '',
        };
    }

}