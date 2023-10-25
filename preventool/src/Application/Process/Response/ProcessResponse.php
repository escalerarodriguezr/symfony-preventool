<?php
declare(strict_types=1);

namespace Preventool\Application\Process\Response;

use DateTimeInterface;
use Preventool\Domain\Process\Model\Process;
use Preventool\Domain\Shared\Model\Value\Uuid;

class ProcessResponse
{
    const ID = 'id';
    const WORKPLACE_ID = 'workplaceId';
    const NAME = 'name';
    const DESCRIPTION = 'description';
    const REVISION_NUMBER = 'revisionNumber';
    const REVISION_OF = 'revisionOf';
    const REVISED_BY = 'revisedBy';
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
        public readonly int $revisionNumber,
        public readonly ?string $revisionOf,
        public readonly ?string $revisedBy,
        public readonly bool $active,
        public readonly ?string $creatorId,
        public readonly ?string $updaterId,
        public readonly \DateTimeImmutable $createdAt,
        public readonly \DateTimeImmutable $updatedAt

    )
    {
    }

    public static function createFromModel(
        Process $model,
        Uuid $workplaceId = null
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
            $model->getDescription()?->decodeValue(),
            $model->getRevisionNumber(),
            $model->getRevisionOf()?->value,
            $model->getRevisedBy()?->value,
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
            self::REVISION_NUMBER => $this->revisionNumber,
            self::REVISED_BY => $this->revisedBy,
            self::REVISION_OF => $this->revisionOf,
            self::ACTIVE => $this->active,
            self::CREATOR_ID => $this->creatorId,
            self::UPDATER_ID => $this->updaterId,
            self::CREATED_AT => $this->createdAt->format(DateTimeInterface::RFC3339),
            self::UPDATED_AT => $this->updatedAt->format(DateTimeInterface::RFC3339),
        ];
    }
}