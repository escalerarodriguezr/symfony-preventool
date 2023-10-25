<?php
declare(strict_types=1);

namespace Preventool\Application\Process\Response;

use DateTimeInterface;
use Preventool\Domain\Process\Model\Process;
use Preventool\Domain\Process\Model\ProcessActivity;
use Preventool\Domain\Shared\Model\Value\Uuid;

class ProcessActivityResponse
{
    const ID = 'id';
    const PROCESS_ID = 'processId';
    const NAME = 'name';
    const DESCRIPTION = 'description';
    const ACTIVITY_ORDER = 'activityOrder';
    const ACTIVE = 'active';
    const CREATOR_ID = 'creatorId';
    const UPDATER_ID = 'updaterId';
    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';

    public function __construct(
        public readonly string $id,
        public readonly string $processId,
        public readonly string $name,
        public readonly ?string $description,
        public readonly int $activityOrder,
        public readonly bool $active,
        public readonly ?string $creatorId,
        public readonly ?string $updaterId,
        public readonly \DateTimeImmutable $createdAt,
        public readonly \DateTimeImmutable $updatedAt

    )
    {
    }

    public static function createFromModel(
        ProcessActivity $model,
        Uuid $processId = null
    ): self
    {

        if($processId != null){
            $processIdResponse = $processId->value;
        }else{
            $processIdResponse = $model->getProcess()->getId()->value;
        }

        return new self(
            $model->getId()->value,
            $processIdResponse,
            $model->getName()->value,
            $model->getDescription()?->decodeValue(),
            $model->getActivityOrder(),
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
            self::PROCESS_ID => $this->processId,
            self::NAME => $this->name,
            self::DESCRIPTION => $this->description,
            self::ACTIVITY_ORDER => $this->activityOrder,
            self::ACTIVE => $this->active,
            self::CREATOR_ID => $this->creatorId,
            self::UPDATER_ID => $this->updaterId,
            self::CREATED_AT => $this->createdAt->format(DateTimeInterface::RFC3339),
            self::UPDATED_AT => $this->updatedAt->format(DateTimeInterface::RFC3339),
        ];
    }
}