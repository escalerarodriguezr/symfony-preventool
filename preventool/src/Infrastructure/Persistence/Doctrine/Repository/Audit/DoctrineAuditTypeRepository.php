<?php

namespace Preventool\Infrastructure\Persistence\Doctrine\Repository\Audit;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Preventool\Domain\Audit\Exception\AuditTypeAlreadyExistsException;
use Preventool\Domain\Audit\Exception\AuditTypeNotFoundException;
use Preventool\Domain\Audit\Model\AuditType;
use Preventool\Domain\Audit\Repository\AuditTypeFilter;
use Preventool\Domain\Audit\Repository\AuditTypeRepository;
use Preventool\Domain\Shared\Model\Value\Name;
use Preventool\Domain\Shared\Model\Value\Uuid;
use Preventool\Domain\Shared\Repository\QueryCondition\QueryCondition;
use Preventool\Domain\Shared\Repository\Response\PaginatedQueryResponse;
use Preventool\Infrastructure\Persistence\Doctrine\Repository\DoctrineBaseRepository;
use Preventool\Infrastructure\Persistence\Doctrine\Repository\Traits\SharedQueryBuilder;

final class DoctrineAuditTypeRepository extends DoctrineBaseRepository implements AuditTypeRepository
{
    use SharedQueryBuilder;
    const MODEL_ALIAS = 'at';
    protected static function entityClass(): string
    {
        return AuditType::class;
    }

    public function save(
        AuditType $auditType
    ): void
    {
        try {
            $this->saveEntity(
                $auditType
            );

        }catch (UniqueConstraintViolationException $exception){

            if( !$auditType->getCompany() && !$auditType->getWorkplace() ){
                throw AuditTypeAlreadyExistsException::forSystemWithName(
                    $auditType->getName()
                );
            }

            if( $auditType->getCompany() && !$auditType->getWorkplace() ){
                throw AuditTypeAlreadyExistsException::forCompanyWithName(
                    $auditType->getName(),
                    $auditType->getCompany()
                );
            }

            if( $auditType->getWorkplace() ){
                throw AuditTypeAlreadyExistsException::forWorkplaceWithName(
                    $auditType->getName(),
                    $auditType->getWorkplace()
                );
            }

        }

    }

    public function findById(Uuid $id): AuditType
    {
        $model = $this->objectRepository->findOneBy([
            'id' => $id->value
        ]);

        if(!$model){
            throw AuditTypeNotFoundException::withId($id);
        }

        return $model;
    }


    public function findSystemAuditTypeByNameOrNull(
        Name $name
    ): ?AuditType
    {

        return $this->objectRepository->findOneBy([
            'name' => $name->value,
            'company' => null,
            'workplace' => null
        ]);
    }



    public function searchPaginated(
        QueryCondition $queryCondition,
        AuditTypeFilter $filter,
        bool $fetchJoinCollections = false
    ): PaginatedQueryResponse
    {
        $queryBuilder = $this->search($filter);

        return $this->paginatedResponse(
            $queryBuilder,
            $queryCondition,
            self::MODEL_ALIAS
        );

    }

    private function search(AuditTypeFilter $filter): QueryBuilder
    {
        $queryBuilder = $this->objectRepository->createQueryBuilder(self::MODEL_ALIAS);


        if(!empty($filter->filterById)){
            $queryBuilder->andWhere(self::MODEL_ALIAS.'.id = :id')
                ->setParameter(
                    ':id',
                    $filter->filterById
                );
        }

        if(empty($filter->filterByCompanyId) && empty($filter->filterByWorkplaceId)){
            $queryBuilder->andWhere(
                $queryBuilder->expr()->isNull(self::MODEL_ALIAS.'.company')
            );
            $queryBuilder->andWhere(
                $queryBuilder->expr()->isNull(self::MODEL_ALIAS.'.workplace')
            );
        }


        if(!empty($filter->filterByCompanyId)){
            $queryBuilder->andWhere(self::MODEL_ALIAS.'.company = :companyId')
                ->setParameter(
                    ':companyId',
                    $filter->filterByCompanyId
                );
        }

        if(!empty($filter->filterByWorkplaceId)){
            $queryBuilder->andWhere(self::MODEL_ALIAS.'.workplace = :workplaceId')
                ->setParameter(
                    ':workplaceId',
                    $filter->filterByWorkplaceId
                );
        }

        return $queryBuilder;
    }

}