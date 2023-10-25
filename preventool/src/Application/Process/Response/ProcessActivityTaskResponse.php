<?php
declare(strict_types=1);

namespace Preventool\Application\Process\Response;

use DateTimeInterface;
use Preventool\Domain\Process\Model\Process;
use Preventool\Domain\Process\Model\ProcessActivity;
use Preventool\Domain\Process\Model\ProcessActivityTask;
use Preventool\Domain\Shared\Model\Value\Uuid;

class ProcessActivityTaskResponse
{
    const ID = 'id';
    const PROCESS_ACTIVITY_ID = 'processActivityId';
    const NAME = 'name';
    const DESCRIPTION = 'description';
    const TASK_ORDER = 'taskOrder';
    const ACTIVE = 'active';
    const CREATOR_ID = 'creatorId';
    const UPDATER_ID = 'updaterId';
    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';

    public function __construct(
        public readonly string $id,
        public readonly string $processActivityId,
        public readonly string $name,
        public readonly ?string $description,
        public readonly int $taskOrder,
        public readonly bool $active,
        public readonly ?string $creatorId,
        public readonly ?string $updaterId,
        public readonly \DateTimeImmutable $createdAt,
        public readonly \DateTimeImmutable $updatedAt

    )
    {
    }

    public static function createFromModel(
        ProcessActivityTask $model,
        Uuid $processActivityId = null
    ): self
    {

        if($processActivityId !== null){
            $processActivityIdResponse = $processActivityId->value;
        }else{
            $processActivityIdResponse = $model->getProcessActivity()->getId()->value;
        }

        return new self(
            $model->getId()->value,
            $processActivityIdResponse,
            $model->getName()->value,
            $model->getDescription()?->decodeValue(),
            $model->getTaskOrder(),
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
            self::PROCESS_ACTIVITY_ID => $this->processActivityId,
            self::NAME => $this->name,
            self::DESCRIPTION => $this->description,
            self::TASK_ORDER => $this->taskOrder,
            self::ACTIVE => $this->active,
            self::CREATOR_ID => $this->creatorId,
            self::UPDATER_ID => $this->updaterId,
            self::CREATED_AT => $this->createdAt->format(DateTimeInterface::RFC3339),
            self::UPDATED_AT => $this->updatedAt->format(DateTimeInterface::RFC3339),
        ];
    }
}