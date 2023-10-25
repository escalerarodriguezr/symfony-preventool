<?php
declare(strict_types=1);

namespace Preventool\Infrastructure\Persistence\Doctrine\Repository\BaselineStudy;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Preventool\Domain\BaselineStudy\Exception\BaselineStudyComplianceOfWorkplaceAlreadyExistsException;
use Preventool\Domain\BaselineStudy\Exception\BaselineStudyComplianceOfWorkplaceNotFoundException;
use Preventool\Domain\BaselineStudy\Model\BaselineStudyCompliance;
use Preventool\Domain\BaselineStudy\Repository\BaselineStudyComplianceRepository;
use Preventool\Domain\Workplace\Model\Workplace;
use Preventool\Infrastructure\Persistence\Doctrine\Repository\DoctrineBaseRepository;

class DoctrineBaselineStudyComplianceRepository extends DoctrineBaseRepository implements BaselineStudyComplianceRepository
{
    protected static function entityClass(): string
    {
        return BaselineStudyCompliance::class;
    }

    public function save(BaselineStudyCompliance $model): void
    {
        try {
            $this->saveEntity($model);
        }catch (UniqueConstraintViolationException $exception){
            throw BaselineStudyComplianceOfWorkplaceAlreadyExistsException::forWorkplace($model->getWorkplace());

        }
    }

    public function findByWorkplace(Workplace $workplace): BaselineStudyCompliance
    {
        $criteria = [
            'workplace' => $workplace->getId()->value
        ];

        $model = $this->objectRepository->findOneBy($criteria);

        if($model === null){
            throw BaselineStudyComplianceOfWorkplaceNotFoundException::forWorkplace($workplace);
        }

        return $model;
    }


}