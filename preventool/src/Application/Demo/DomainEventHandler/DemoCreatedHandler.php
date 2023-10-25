<?php
declare(strict_types=1);

namespace Preventool\Application\Demo\DomainEventHandler;

use Preventool\Domain\Demo\DomainEvent\DemoCreated;
use Preventool\Domain\Shared\Bus\DomainEvent\DomainEventHandler;

class DemoCreatedHandler implements DomainEventHandler
{
    public function __invoke(DemoCreated $demoCreated): void
    {
       throw new \Exception('hola');
    }


}