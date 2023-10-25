<?php
declare(strict_types=1);

namespace Preventool\Domain\Shared\Bus\DomainEvent;

interface DomainEventBus
{
    public function dispatch(DomainEvent $domainEvent): void;

}