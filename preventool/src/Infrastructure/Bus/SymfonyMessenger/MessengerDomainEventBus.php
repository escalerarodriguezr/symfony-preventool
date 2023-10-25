<?php
declare(strict_types=1);

namespace Preventool\Infrastructure\Bus\SymfonyMessenger;

use Preventool\Domain\Shared\Bus\DomainEvent\DomainEvent;
use Preventool\Domain\Shared\Bus\DomainEvent\DomainEventBus;
use Symfony\Component\Messenger\MessageBusInterface;

final class MessengerDomainEventBus implements DomainEventBus
{
    public function __construct(
        private readonly MessageBusInterface $domainEventBus
    )
    {
    }

    public function dispatch(DomainEvent $domainEvent): void
    {
        $this->domainEventBus->dispatch($domainEvent);
    }

}