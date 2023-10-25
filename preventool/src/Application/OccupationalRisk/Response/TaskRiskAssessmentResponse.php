<?php
declare(strict_types=1);

namespace Preventool\Application\OccupationalRisk\Response;

use DateTimeInterface;
use Preventool\Domain\OccupationalRisk\Model\TaskRiskAssessment;

class TaskRiskAssessmentResponse
{

    const ID = 'id';
    const taskRiskId = 'taskRiskId';
    const STATUS = 'status';
    const REVISION = 'revision';
    const SEVERITY_INDEX = 'severityIndex';
    const PEOPLE_EXPOSED_INDEX = 'peopleExposedIndex';
    const PROCEDURE_INDEX = 'procedureIndex';
    const TRAINING_INDEX = 'trainingIndex';
    const EXPOSURE_INDEX = 'exposureIndex';
    const RISK_LEVEL_INDEX = 'riskLevelIndex';
    const REVISED_ADMIN = 'revisedAdminId';
    const APPROVED_ADMIN = 'approvedAdminId';
    const CREATOR_ID = 'creatorId';
    const UPDATER_ID = 'updaterId';
    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';

    public function __construct(
        public readonly string $id,
        public readonly string $taskRiskId,
        public readonly string $status,
        public readonly int $revision,
        public readonly int $severityIndex,
        public readonly int $peopleExposedIndex,
        public readonly int $procedureIndex,
        public readonly int $trainingIndex,
        public readonly int $exposureIndex,
        public readonly int $riskLevelIndex,
        public readonly ?string $revisedAdminId,
        public readonly ?string $approvedAdminId,
        public readonly ?string $creatorId,
        public readonly ?string $updaterId,
        public readonly \DateTimeImmutable $createdAt,
        public readonly \DateTimeImmutable $updatedAt,
    )
    {
    }

    public static function createFromModel(TaskRiskAssessment $model): self
    {
        return new self(
            $model->getId()->value,
            $model->getTaskRisk()->getId()->value,
            $model->getStatus()->value,
            $model->getRevision(),
            $model->getSeverityIndex()->value,
            $model->getPeopleExposedIndex()->value,
            $model->getProcedureIndex()->value,
            $model->getTrainingIndex()->value,
            $model->getExposureIndex()->value,
            $model->getRiskLevelIndex()->value,
            $model->getRevisedAdmin()?->getId()->value,
            $model->getApprovedAdmin()?->getId()->value,
            $model->getCreatorAdmin()?->getId()->value,
            $model->getUpdaterAdmin()?->getId()->value,
            $model->getCreatedAt(),
            $model->getUpdatedAt()
        );
    }

    public function toArray(): array
    {
        return [
            self::ID => $this->id,
            self::taskRiskId => $this->taskRiskId,
            self::STATUS => $this->status,
            self::REVISION => $this->revision,
            self::SEVERITY_INDEX => $this->severityIndex,
            self::PEOPLE_EXPOSED_INDEX => $this->peopleExposedIndex,
            self::PROCEDURE_INDEX => $this->procedureIndex,
            self::TRAINING_INDEX => $this->trainingIndex,
            self::EXPOSURE_INDEX => $this->exposureIndex,
            self::RISK_LEVEL_INDEX => $this->riskLevelIndex,
            self::REVISED_ADMIN => $this->revisedAdminId,
            self::APPROVED_ADMIN => $this->approvedAdminId,
            self::CREATOR_ID => $this->creatorId,
            self::UPDATER_ID => $this->updaterId,
            self::CREATED_AT => $this->createdAt->format(DateTimeInterface::RFC3339),
            self::UPDATED_AT => $this->updatedAt->format(DateTimeInterface::RFC3339),
        ];
    }


}