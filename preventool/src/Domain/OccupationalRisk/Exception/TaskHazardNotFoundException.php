<?php
declare(strict_types=1);

namespace Preventool\Domain\OccupationalRisk\Exception;

use Preventool\Domain\Shared\Model\Value\Uuid;

class TaskHazardNotFoundException extends \DomainException
{
    public static function withId(Uuid $id): self
    {
        return new self(
            sprintf('TaskHazard with id %s not found', $id->value)
        );
    }

}