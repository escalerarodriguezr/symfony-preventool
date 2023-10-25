<?php
declare(strict_types=1);

namespace Preventool\Application\Admin\GetAdminById;

use Preventool\Domain\Shared\Bus\Query\Query;

class GetAdminByIdQuery implements Query
{

    public function __construct(
        public readonly string $actionAdminId,
        public readonly string $id
    )
    {
    }
}