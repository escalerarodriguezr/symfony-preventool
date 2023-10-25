<?php
declare(strict_types=1);

namespace Preventool\Domain\Shared\Bus\Query;

interface QueryBus
{
    public function handle(Query $query): mixed;

}