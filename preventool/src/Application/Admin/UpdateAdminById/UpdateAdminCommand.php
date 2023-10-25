<?php
declare(strict_types=1);

namespace Preventool\Application\Admin\UpdateAdminById;

use Preventool\Domain\Shared\Bus\Command\Command;

class UpdateAdminCommand implements Command
{
    public function __construct(
        public readonly string $actionAdminId,
        public readonly string $id,
        public readonly ?string $name = null,
        public readonly ?string $lastName = null,
        public readonly ?string $role = null,
        public readonly ?string $email = null
    )
    {
    }

}