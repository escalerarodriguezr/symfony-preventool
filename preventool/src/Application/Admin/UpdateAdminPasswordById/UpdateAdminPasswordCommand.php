<?php
declare(strict_types=1);

namespace Preventool\Application\Admin\UpdateAdminPasswordById;

use Preventool\Domain\Shared\Bus\Command\Command;

class UpdateAdminPasswordCommand implements Command
{
    public function __construct(
        public readonly string $actionAdminId,
        public readonly string $id,
        public readonly string $currentPassword,
        public readonly string $password,

    )
    {
    }

}