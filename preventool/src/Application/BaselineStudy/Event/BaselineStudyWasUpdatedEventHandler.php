<?php
declare(strict_types=1);

namespace Preventool\Application\BaselineStudy\Event;

use Preventool\Domain\BaselineStudy\Service\UpdateBaselineStudyComplianceByIndicator;
use Preventool\Domain\Shared\Bus\DomainEvent\DomainEventHandler;
use Preventool\Domain\Shared\Model\Value\Uuid;

class BaselineStudyWasUpdatedEventHandler implements DomainEventHandler
{

    public function __construct(
        private readonly UpdateBaselineStudyComplianceByIndicator $updateBaselineStudyComplianceByIndicator
    )
    {
    }

    public function __invoke(
        BaselineStudyWasUpdatedEvent $event
    ): void
    {

        $indicatorUuid = new Uuid($event->baselineStudyId);

        $this->updateBaselineStudyComplianceByIndicator->__invoke(
           $indicatorUuid
        );
    }

}