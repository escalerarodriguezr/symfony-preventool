<?php
declare(strict_types=1);

namespace Preventool\Application\Process\CreateActivityTask;

use Preventool\Domain\Shared\Bus\Command\Command;

class CreateActivityTaskCommand implements Command
{


    public function __construct(
        public readonly string $actionAdminId,
        public readonly string $activityId,
        public readonly string $taskId,
        public readonly string $name,
        public readonly ?string $description
    )
    {
    }
}