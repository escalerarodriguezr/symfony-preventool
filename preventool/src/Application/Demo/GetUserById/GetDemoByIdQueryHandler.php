<?php

namespace Preventool\Application\Demo\GetUserById;

use Preventool\Domain\Shared\Bus\Query\QueryHandler;

class GetDemoByIdQueryHandler implements QueryHandler
{
    public function __invoke(
        GetDemoByIdQuery $query
    ): string
    {
        return $query->id;

    }


}