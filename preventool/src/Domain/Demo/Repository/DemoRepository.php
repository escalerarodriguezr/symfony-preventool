<?php
declare(strict_types=1);

namespace Preventool\Domain\Demo\Repository;

use Preventool\Domain\Demo\Model\Demo;

interface DemoRepository
{
    public function findById(
        string $id
    ): ?Demo;

    public function save(
        Demo $demo
    ): void;

    public function remove(
        Demo $demo
    ): void;

}