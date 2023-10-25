<?php
declare(strict_types=1);

namespace Preventool\Domain\OccupationalRisk\Repository;

use Preventool\Domain\OccupationalRisk\Model\TaskHazard;
use Preventool\Domain\Shared\Model\Value\Uuid;

interface TaskHazardRepository
{
    public function save(TaskHazard $taskHazard):void;
    public function findById(Uuid $id): TaskHazard;
    public function delete( TaskHazard $model): void;

    public function getAllByTaskId(Uuid $taskId): array;

}