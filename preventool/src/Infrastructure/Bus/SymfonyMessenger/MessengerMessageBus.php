<?php
declare(strict_types=1);

namespace Preventool\Infrastructure\Bus\SymfonyMessenger;

use Preventool\Domain\Shared\Bus\Message\Message;
use Preventool\Domain\Shared\Bus\Message\MessageBus;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\DispatchAfterCurrentBusStamp;

final class MessengerMessageBus implements MessageBus
{


    public function __construct(
        private readonly MessageBusInterface $messageBus
    )
    {
    }

    public function publish(Message $message): void
    {
        $this->messageBus->dispatch(
            (new Envelope($message))
                ->with(new DispatchAfterCurrentBusStamp())
        );
    }


}