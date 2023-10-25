<?php
declare(strict_types=1);

namespace Preventool\Application\OccupationalRisk\Response;

use DateTimeInterface;
use Preventool\Domain\OccupationalRisk\Model\TaskHazard;
use function Symfony\Component\DependencyInjection\Loader\Configurator\service_locator;

class TaskHazardResponse
{

    const ID = 'id';
    const HAZARD_NAME = 'hazardName';
    const HAZARD_DESCRIPTION = 'hazardDescription';
    const HAZARD_CATEGORY_NAME = 'hazardCategoryName';
    const RISK_ID = 'riskId';
    const RISK_NAME = 'riskName';
    const ACTIVE = 'active';
    const STATUS = 'status';
    const CREATOR_ID = 'creatorId';
    const UPDATER_ID = 'updaterId';
    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';

    public function __construct(
        public readonly string $id,
        public readonly string $hazardName,
        public readonly ?string $hazardDescription,
        public readonly string $hazardCategoryName,
        public readonly string $riskId,
        public readonly string $riskName,
        public readonly bool $active,
        public readonly string $status,
        public readonly ?string $creatorId,
        public readonly ?string $updaterId,
        public readonly \DateTimeImmutable $createdAt,
        public readonly \DateTimeImmutable $updatedAt

    )
    {
    }

    public static function createFromModel(TaskHazard $model): self
    {
        return new self(
            $model->getId()->value,
            $model->getHazardName()->value,
            $model->getHazardDescription()?->value,
            $model->getHazardCategoryName()->value,
            $model->getTaskRisk()->getId()->value,
            $model->getTaskRisk()->getName()->value,
            $model->isActive(),
            $model->getTaskRisk()->getStatus()->value,
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
            self::HAZARD_NAME => $this->hazardName,
            self::HAZARD_DESCRIPTION => $this->hazardDescription,
            self::HAZARD_CATEGORY_NAME => $this->hazardCategoryName,
            self::RISK_ID => $this->riskId,
            self::RISK_NAME => $this->riskName,
            self::ACTIVE => $this->active,
            self::STATUS => $this->status,
            self::CREATOR_ID => $this->creatorId,
            self::UPDATER_ID => $this->updaterId,
            self::CREATED_AT => $this->createdAt->format(DateTimeInterface::RFC3339),
            self::UPDATED_AT => $this->updatedAt->format(DateTimeInterface::RFC3339),
        ];
    }


}