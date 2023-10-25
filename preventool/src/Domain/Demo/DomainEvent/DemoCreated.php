<?php

namespace Preventool\Domain\Demo\DomainEvent;

use Preventool\Domain\Shared\Bus\DomainEvent\DomainEvent;

class DemoCreated implements DomainEvent
{
    public function __construct(
        public readonly string $id
    )
    {
    }

}