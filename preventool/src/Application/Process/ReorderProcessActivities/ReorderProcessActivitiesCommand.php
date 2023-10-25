<?php
declare(strict_types=1);

namespace Preventool\Application\Process\ReorderProcessActivities;

use Preventool\Domain\Shared\Bus\Command\Command;

class ReorderProcessActivitiesCommand implements Command
{

    /**
     * @param string[] $order
     */
    public function __construct(
        public readonly string $actionAdminId,
        public readonly string $processId,
        public readonly array $order
    )
    {
    }
}