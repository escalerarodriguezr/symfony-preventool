<?php
declare(strict_types=1);

namespace Preventool\Domain\OccupationalRisk\Model\Value;

use Assert\Assertion;
use Assert\AssertionFailedException;

class TaskRiskStatus
{
    const PENDING_ASSESSMENT = 'PENDING-ASSESSMENT';
    const DRAFT_ASSESSMENT = 'DRAFT-ASSESSMENT';

    const REVISED_ASSESSMENT = 'REVISED-ASSESSMENT';

    const APPROVED_ASSESSMENT = 'APPROVED-ASSESSMENT';

    const VALID_OPTIONS = [
        self::PENDING_ASSESSMENT,
        self::DRAFT_ASSESSMENT,
        self::REVISED_ASSESSMENT,
        self::APPROVED_ASSESSMENT
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
            self::PENDING_ASSESSMENT => 'Pendiente de evaluar',
            self::DRAFT_ASSESSMENT => 'Evaluación en borrador',
            self::REVISED_ASSESSMENT => 'Evaluación revisada',
            self::APPROVED_ASSESSMENT => 'Evaluación aprobada',
            default => '',
        };
    }

}