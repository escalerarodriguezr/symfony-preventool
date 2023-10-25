<?php
declare(strict_types=1);

namespace Preventool\Application\Admin\Event\AdminCreated;

use Preventool\Domain\Shared\Bus\DomainEvent\DomainEvent;

class AdminCreatedEvent implements DomainEvent
{

    public function __construct(
        public readonly string $adminId
    )
    {
    }
}