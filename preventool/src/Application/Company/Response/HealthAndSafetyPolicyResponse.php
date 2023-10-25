<?php
declare(strict_types=1);

namespace Preventool\Application\Company\Response;

use DateTimeInterface;
use Preventool\Domain\Company\Model\Company;
use Preventool\Domain\Company\Model\HealthAndSafetyPolicy;

class HealthAndSafetyPolicyResponse
{
    const ID = 'id';
    const COMPANY_ID = 'companyId';
    const STATUS = 'status';
    const DOCUMENT_RESOURCE = 'documentResource';

    const ACTIVE = 'active';
    const APPROVED_ADMIN_ID = 'approvedAdminId';
    const CREATOR_ID = 'creatorId';
    const UPDATER_ID = 'updaterId';
    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';

    private function __construct(
        public readonly string $id,
        public readonly string $companyId,
        public readonly string $status,
        public readonly ?string $documentResource,
        public readonly bool $active,
        public readonly ?string $approvedAdminId,
        public readonly ?string $creatorId,
        public readonly ?string $updaterId,
        public readonly \DateTimeImmutable $createdAt,
        public readonly \DateTimeImmutable $updatedAt

    )
    {
    }

    public static function createFromModel(
        HealthAndSafetyPolicy $model
    ): self
    {
        return new self(
            $model->getId()->value,
            $model->getCompany()->getId()->value,
            $model->getStatus()->value,
            $model->getDocumentResource(),
            $model->isActive(),
            $model->getApprovedAdmin() ? $model->getApprovedAdmin()->getId()->value : null,
            $model->getCreatorAdmin() ? $model->getCreatorAdmin()->getId()->value : null,
            $model->getUpdaterAdmin() ? $model->getUpdaterAdmin()->getId()->value : null,
            $model->getCreatedAt(),
            $model->getUpdatedAt()
        );
    }

    public function toArray(): array
    {
        return [
            self::ID => $this->id,
            self::COMPANY_ID => $this->companyId,
            self::STATUS => $this->status,
            self::DOCUMENT_RESOURCE => $this->documentResource,
            self::ACTIVE => $this->active,
            self::APPROVED_ADMIN_ID => $this->approvedAdminId,
            self::CREATOR_ID => $this->creatorId,
            self::UPDATER_ID => $this->updaterId,
            self::CREATED_AT => $this->createdAt->format(DateTimeInterface::RFC3339),
            self::UPDATED_AT => $this->updatedAt->format(DateTimeInterface::RFC3339),
        ];
    }
    
}