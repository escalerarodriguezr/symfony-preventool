<?php
declare(strict_types=1);

namespace Preventool\Infrastructure\Persistence\Doctrine\Repository\WorkplaceHazard;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Preventool\Domain\WorkplaceHazard\Exception\WorkplaceHazardCategoryAlreadyExistsException;
use Preventool\Domain\WorkplaceHazard\Model\WorkplaceHazardCategory;
use Preventool\Domain\WorkplaceHazard\Repository\WorkplaceHazardCategoryRepository;
use Preventool\Infrastructure\Persistence\Doctrine\Repository\DoctrineBaseRepository;


class DoctrineWorkplaceHazardCategoryRepository extends DoctrineBaseRepository implements WorkplaceHazardCategoryRepository
{
    protected static function entityClass(): string
    {
        return WorkplaceHazardCategory::class;
    }

    public function save(WorkplaceHazardCategory $model): void
    {
        try {
            $this->saveEntity($model);
        }catch (UniqueConstraintViolationException $exception){
            throw WorkplaceHazardCategoryAlreadyExistsException::withNameForWorkplace(
                $model->getName(),
                $model->getWorkplace()->getId()
            );
        }
    }


}