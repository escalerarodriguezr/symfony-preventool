<?php
declare(strict_types=1);

namespace Preventool\Application\Demo\GetUserById;

use Preventool\Domain\Shared\Bus\Query\Query;

class GetDemoByIdQuery implements Query
{
    public function __construct(
        public readonly string $id
    )
    {
    }
}