<?php
declare(strict_types=1);

namespace Preventool\Application\Admin\CreateAdmin;

use Container5cdiJcc\getDoctrine_Orm_DefaultEntityManager_PropertyInfoExtractorService;
use Preventool\Domain\Shared\Bus\Command\Command;

class CreateAdminCommand implements Command
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly string $lastName,
        public readonly string $email,
        public readonly string $password,
        public readonly string $role,
        public readonly string $actionAdminId
    )
    {
    }
}