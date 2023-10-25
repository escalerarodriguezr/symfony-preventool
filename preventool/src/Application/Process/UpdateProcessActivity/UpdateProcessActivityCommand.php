<?php
declare(strict_types=1);

namespace Preventool\Application\Process\UpdateProcessActivity;

use Preventool\Domain\Shared\Bus\Command\Command;

class UpdateProcessActivityCommand implements Command
{


    public function __construct(
        public readonly string $actionAdminId,
        public readonly string $activityId,
        public readonly string $name,
        public readonly ?string $description
    )
    {
    }
}