<?php
declare(strict_types=1);

namespace Preventool\Domain\OccupationalRisk\Repository;

use Preventool\Domain\OccupationalRisk\Model\TaskRiskAssessment;
use Preventool\Domain\Shared\Model\Value\Uuid;

interface TaskRiskAssessmentRepository
{
    public function save(TaskRiskAssessment $model): void;
    public function delete(TaskRiskAssessment $model): void;
    public function findById(Uuid $id): TaskRiskAssessment;
    public function findByTaskRiskId(Uuid $id): TaskRiskAssessment;


}