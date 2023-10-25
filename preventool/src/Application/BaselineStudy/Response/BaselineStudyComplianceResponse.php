<?php
declare(strict_types=1);

namespace Preventool\Application\BaselineStudy\Response;

use DateTimeInterface;
use Preventool\Domain\BaselineStudy\Model\BaselineStudyCompliance;

class BaselineStudyComplianceResponse
{
    const ID = 'id';
    const WORKPLACE_ID = 'workplaceId';
    const TOTAL_COMPLIANCE = 'totalCompliance';
    const COMPROMISO_COMPLIANCE = 'compromisoCompliance';
    const POLITICA_COMPLIANCE = 'politicaCompliance';
    const PLANEAMIENTO_COMPLIANCE = 'planeamientoCompliance';
    const IMPLEMENTACION_COMPLIANCE = 'implementacionCompliance';
    const EVALUACION_COMPLIANCE = 'evaluacionCompliance';
    const VERIFICACION_COMPLIANCE = 'verificacionCompliance';
    const CONTROL_COMPLIANCE = 'controlCompliance';
    const REVISION_COMPLIANCE = 'revisionCompliance';
    const CREATOR_ID = 'creatorId';
    const UPDATER_ID = 'updaterId';
    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';

    private function __construct(
        public readonly string $id,
        public readonly string $workplaceId,
        public readonly int $totalCompliance,
        public readonly int $compromisoCompliance,
        public readonly int $politicaCompliance,
        public readonly int $planteamientoCompliance,
        public readonly int $implementacionCompliance,
        public readonly int $evaluacionCompliance,
        public readonly int $verificacionCompliance,
        public readonly int $controlCompliance,
        public readonly int $revisionCompliance,
        public readonly ?string $creatorId,
        public readonly ?string $updaterId,
        public readonly \DateTimeImmutable $createdAt,
        public readonly \DateTimeImmutable $updatedAt

    )
    {
    }

    public static function createFromModel(
        BaselineStudyCompliance $model
    ): self
    {
        return new self(
            $model->getId()->value,
            $model->getWorkplace()->getId()->value,
            $model->getTotalCompliance()->value,
            $model->getCompromisoCompliance()->value,
            $model->getPoliticaCompliance()->value,
            $model->getPlaneamientoCompliance()->value,
            $model->getImplementacionCompliance()->value,
            $model->getEvaluacionCompliance()->value,
            $model->getVerificacionCompliance()->value,
            $model->getControlCompliance()->value,
            $model->getRevisionCompliance()->value,
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
            self::TOTAL_COMPLIANCE => $this->totalCompliance,
            self::COMPROMISO_COMPLIANCE => $this->compromisoCompliance,
            self::POLITICA_COMPLIANCE => $this->politicaCompliance,
            self::PLANEAMIENTO_COMPLIANCE => $this->planteamientoCompliance,
            self::IMPLEMENTACION_COMPLIANCE => $this->implementacionCompliance,
            self::EVALUACION_COMPLIANCE => $this->evaluacionCompliance,
            self::VERIFICACION_COMPLIANCE => $this->verificacionCompliance,
            self::CONTROL_COMPLIANCE => $this->controlCompliance,
            self::REVISION_COMPLIANCE => $this->revisionCompliance,
            self::CREATOR_ID => $this->creatorId,
            self::UPDATER_ID => $this->updaterId,
            self::CREATED_AT => $this->createdAt->format(DateTimeInterface::RFC3339),
            self::UPDATED_AT => $this->updatedAt->format(DateTimeInterface::RFC3339),
        ];
    }

}