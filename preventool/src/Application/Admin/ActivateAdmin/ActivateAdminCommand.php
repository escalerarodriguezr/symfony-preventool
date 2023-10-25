<?php
declare(strict_types=1);

namespace Preventool\Application\Admin\ActivateAdmin;

use Preventool\Domain\Shared\Bus\Command\Command;

class ActivateAdminCommand implements Command
{


    public function __construct(
        public readonly string $actionAdminId,
        public readonly string $adminId
    )
    {
    }
}