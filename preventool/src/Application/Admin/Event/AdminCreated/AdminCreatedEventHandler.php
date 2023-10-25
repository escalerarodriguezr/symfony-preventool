<?php
declare(strict_types=1);

namespace Preventool\Application\Admin\Event\AdminCreated;

use Preventool\Application\Admin\SendConfirmationEmailOnAdminCreated\SendConfirmationEmailMessage;
use Preventool\Domain\Shared\Bus\DomainEvent\DomainEventHandler;
use Preventool\Domain\Shared\Bus\Message\MessageBus;

class AdminCreatedEventHandler implements DomainEventHandler
{

    public function __construct(
        private readonly MessageBus $messageBus
    )
    {
    }

    public function __invoke(
        AdminCreatedEvent $event
    ): void
    {
        $this->messageBus->publish(
            new SendConfirmationEmailMessage(
                $event->adminId
            )
        );

        // TODO: Implement __invoke() method.
    }


}