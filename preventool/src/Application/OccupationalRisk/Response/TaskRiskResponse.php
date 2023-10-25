<?php
declare(strict_types=1);

namespace Preventool\Application\OccupationalRisk\Response;

use DateTimeInterface;
use Preventool\Domain\OccupationalRisk\Model\TaskRisk;

class TaskRiskResponse
{

    const ID = 'id';
    const NAME = 'name';
    const STATUS = 'status';
    const OBSERVATIONS = 'observations';
    const LEGAL_REQUIREMENT = 'legalRequirement';
    const CREATOR_ID = 'creatorId';
    const UPDATER_ID = 'updaterId';
    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';
    const HAZARD_ID = 'hazardId';
    const HAZARD_NAME = 'hazardName';
    const HAZARD_DESCRIPTION = 'hazardDescription';
    const HAZARD_CATEGORY_NAME = 'hazardCategoryName';
    const PROCESS_ACTIVITY_TASK_ID = 'taskId';


    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly string $status,
        public readonly ?string $observations,
        public readonly ?string $legalRequirement,
        public readonly ?string $creatorId,
        public readonly ?string $updaterId,
        public readonly \DateTimeImmutable $createdAt,
        public readonly \DateTimeImmutable $updatedAt,
        public readonly string $hazardId,
        public readonly string $hazardName,
        public readonly ?string $hazardDescription,
        public readonly string $hazardCategoryName,
        public readonly string$taskId

    )
    {
    }

    public static function createFromModel(TaskRisk $model): self
    {
        return new self(
            $model->getId()->value,
            $model->getName()->value,
            $model->getStatus()->value,
            $model->getObservations()?->value,
            $model->getLegalRequirement()?->value,
            $model->getCreatorAdmin()?->getId()->value,
            $model->getUpdaterAdmin()?->getId()->value,
            $model->getCreatedAt(),
            $model->getUpdatedAt(),
            $model->getTaskHazard()->getId()->value,
            $model->getTaskHazard()->getHazardName()->value,
            $model->getTaskHazard()->getHazardDescription()?->value,
            $model->getTaskHazard()->getHazardCategoryName()->value,
            $model->getTaskHazard()->getTask()->getId()->value
        );
    }

    public function toArray(): array
    {
        return [
            self::ID => $this->id,
            self::NAME => $this->name,
            self::STATUS => $this->status,
            self::OBSERVATIONS => $this->observations,
            self::LEGAL_REQUIREMENT => $this->legalRequirement,
            self::CREATOR_ID => $this->creatorId,
            self::UPDATER_ID => $this->updaterId,
            self::CREATED_AT => $this->createdAt->format(DateTimeInterface::RFC3339),
            self::UPDATED_AT => $this->updatedAt->format(DateTimeInterface::RFC3339),
            self::HAZARD_ID => $this->hazardId,
            self::HAZARD_NAME => $this->hazardName,
            self::HAZARD_DESCRIPTION => $this->hazardDescription,
            self::HAZARD_CATEGORY_NAME => $this->hazardCategoryName,
            self::PROCESS_ACTIVITY_TASK_ID => $this->taskId,
        ];
    }


}