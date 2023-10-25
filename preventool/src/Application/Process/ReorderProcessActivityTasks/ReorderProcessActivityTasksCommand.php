<?php
declare(strict_types=1);

namespace Preventool\Application\Process\ReorderProcessActivityTasks;

use Preventool\Domain\Shared\Bus\Command\Command;

class ReorderProcessActivityTasksCommand implements Command
{

    public function __construct(
        public readonly string $actionAdminId,
        public readonly string $processActivityId,
        public readonly array $order
    )
    {
    }
}