<?php
declare(strict_types=1);

namespace Preventool\Domain\OccupationalRisk\Repository;

use Preventool\Domain\OccupationalRisk\Model\TaskRisk;
use Preventool\Domain\OccupationalRisk\Repository\TaskRiskRepository\CountOfStatusByWorkplaceQueryResponse;
use Preventool\Domain\Shared\Model\Value\Uuid;
use Preventool\Domain\Workplace\Model\Workplace;

interface TaskRiskRepository
{
    public function save(TaskRisk $taskRisk): void;
    public function findById(Uuid $id): TaskRisk;
    public function delete(TaskRisk $model): void;

    public function countOfStatusByWorkplaceQuery(Workplace $workplace): CountOfStatusByWorkplaceQueryResponse;


}