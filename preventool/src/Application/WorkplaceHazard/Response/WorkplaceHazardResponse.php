<?php
declare(strict_types=1);

namespace Preventool\Application\WorkplaceHazard\Response;

use DateTimeInterface;
use Preventool\Domain\Shared\Model\Value\Uuid;
use Preventool\Domain\WorkplaceHazard\Model\WorkplaceHazard;

class WorkplaceHazardResponse
{
    const ID = 'id';
    const WORKPLACE_ID = 'workplaceId';
    const NAME = 'name';
    const DESCRIPTION = 'description';
    const CATEGORY_NAME = 'categoryName';
    const ACTIVE = 'active';
    const CREATOR_ID = 'creatorId';
    const UPDATER_ID = 'updaterId';
    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';

    public function __construct(
        public readonly string $id,
        public readonly string $workplaceId,
        public readonly string $name,
        public readonly ?string $description,
        public readonly string $categoryName,
        public readonly bool $active,
        public readonly ?string $creatorId,
        public readonly ?string $updaterId,
        public readonly \DateTimeImmutable $createdAt,
        public readonly \DateTimeImmutable $updatedAt

    )
    {
    }

    public static function createFromModel(
        WorkplaceHazard $model,
        Uuid $workplaceId
    ): self
    {
        if($workplaceId != null){
            $workplaceIdResponse = $workplaceId->value;
        }else{
            $workplaceIdResponse = $model->getWorkplace()->getId()->value;
        }

        return new self(
            $model->getId()->value,
            $workplaceIdResponse,
            $model->getName()->value,
            $model->getDescription()?->value,
            $model->getWorkplaceHazardCategory()->getName()->value,
            $model->isActive(),
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
            self::WORKPLACE_ID => $this->workplaceId,
            self::NAME => $this->name,
            self::DESCRIPTION => $this->description,
            self::CATEGORY_NAME => $this->categoryName,
            self::ACTIVE => $this->active,
            self::CREATOR_ID => $this->creatorId,
            self::UPDATER_ID => $this->updaterId,
            self::CREATED_AT => $this->createdAt->format(DateTimeInterface::RFC3339),
            self::UPDATED_AT => $this->updatedAt->format(DateTimeInterface::RFC3339),
        ];
    }


}