<?php
declare(strict_types=1);

namespace Preventool\Application\AuditType\Response;

use Container5MOI6Fx\getDoctrine_Fixtures_Purger_OrmPurgerFactoryService;
use DateTimeInterface;
use Preventool\Domain\Audit\Model\AuditType;
use function Symfony\Component\DependencyInjection\Loader\Configurator\service_locator;

class AuditTypeResponse
{

    const ID = 'id';
    const SCOPE = 'scope';
    const NAME = 'name';
    const DESCRIPTION = 'description';
    const COMPANY_ID = 'companyId';
    const WORKPLACE_ID = 'workplaceId';
    const ACTIVE = 'active';
    const CREATOR_ID = 'creatorId';
    const UPDATER_ID = 'updaterId';
    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';


    public function __construct(
        public readonly string $id,
        public readonly string $scope,
        public readonly string $name,
        public readonly ?string $description,
        public readonly bool $active,
        public readonly ?string $companyId,
        public readonly ?string $workplaceId,
        public readonly ?string $creatorId,
        public readonly ?string $updaterId,
        public readonly \DateTimeImmutable $createdAt,
        public readonly \DateTimeImmutable $updatedAt

    )
    {
    }

    public static function createFromModel(AuditType $model): self
    {
        $description = $model->getDescription()?->value ?? null;
        $companyId = $model->getCompany()?->getId()->value ?? null;
        $workplaceId = $model->getWorkplace()?->getId()->value ?? null;

        return new self(
            $model->getId()->value,
            $model->getScope()->value,
            $model->getName()->value,
            $description,
            $model->isActive(),
            $companyId,
            $workplaceId,
            $model->getCreatorAdmin()?->getId()->value ?? null,
            $model->getUpdaterAdmin()?->getId()->value ?? null,
            $model->getCreatedAt(),
            $model->getUpdatedAt()

        );
    }

    public function toArray(): array
    {
        return [
            self::ID => $this->id,
            self::SCOPE => $this->scope,
            self::NAME => $this->name,
            self::DESCRIPTION => $this->description,
            self::ACTIVE => $this->active,
            self::COMPANY_ID => $this->companyId,
            self::WORKPLACE_ID => $this->workplaceId,
            self::CREATOR_ID => $this->creatorId,
            self::UPDATER_ID => $this->updaterId,
            self::CREATED_AT => $this->createdAt->format(DateTimeInterface::RFC3339),
            self::UPDATED_AT => $this->updatedAt->format(DateTimeInterface::RFC3339)
        ];
    }
}