<?php
declare(strict_types=1);

namespace Preventool\Application\BaselineStudy\Event;

use Preventool\Domain\Shared\Bus\DomainEvent\DomainEvent;

class BaselineStudyWasUpdatedEvent implements DomainEvent
{
    public function __construct(
        public readonly string $baselineStudyId
    )
    {
    }


}