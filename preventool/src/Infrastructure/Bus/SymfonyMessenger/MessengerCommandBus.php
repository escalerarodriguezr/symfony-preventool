<?php
declare(strict_types=1);

namespace Preventool\Infrastructure\Bus\SymfonyMessenger;

use Preventool\Domain\Shared\Bus\Command\Command;
use Preventool\Domain\Shared\Bus\Command\CommandBus;
use Symfony\Component\Messenger\MessageBusInterface;

final class MessengerCommandBus implements CommandBus
{

    public function __construct(
        private readonly MessageBusInterface $commandBus
    )
    {
    }

    public function dispatch(
        Command $command
    ): void
    {
        $this->commandBus->dispatch($command);
    }

}