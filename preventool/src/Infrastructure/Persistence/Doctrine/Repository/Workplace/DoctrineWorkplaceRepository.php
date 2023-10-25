<?php
declare(strict_types=1);

namespace Preventool\Infrastructure\Persistence\Doctrine\Repository\Workplace;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Preventool\Domain\Shared\Model\Value\Uuid;
use Preventool\Domain\Workplace\Exception\WorkplaceAlreadyExistsException;
use Preventool\Domain\Workplace\Exception\WorkplaceNotFoundException;
use Preventool\Domain\Workplace\Model\Workplace;
use Preventool\Domain\Workplace\Repository\WorkplaceFilter;
use Preventool\Domain\Workplace\Repository\WorkplaceRepository;
use Preventool\Infrastructure\Persistence\Doctrine\Repository\DoctrineBaseRepository;
use Preventool\Domain\Shared\Repository\QueryCondition\QueryCondition;
use Preventool\Domain\Shared\Repository\Response\PaginatedQueryResponse;

class DoctrineWorkplaceRepository extends DoctrineBaseRepository implements WorkplaceRepository
{

    const MODEL_ALIAS = 'w';

    protected static function entityClass(): string
    {
        return Workplace::class;
    }

    public function save(
        Workplace $workplace
    ): void
    {
        try{
            $this->saveEntity($workplace);

        }catch (UniqueConstraintViolationException $exception){

            throw WorkplaceAlreadyExistsException::forCompanyWithName(
                $workplace->getCompany(),
                $workplace->getName()
            );
        }
    }

    public function findById(Uuid $id): Workplace
    {
        $workplace = $this->objectRepository->findOneBy(
            ['id' => $id->value]
        );

        if($workplace == null){
            throw WorkplaceNotFoundException::withId($id);
        }

        return $workplace;
    }

    public function delete(Workplace $workplace): void
    {
        $this->removeEntity($workplace);
    }


    public function searchPaginated(
        QueryCondition $queryCondition,
        WorkplaceFilter $filter,
        bool $fetchJoinCollections=false
    ): PaginatedQueryResponse
    {
        $queryBuilder = $this->search($filter);
        $queryBuilder
            ->setFirstResult($queryCondition->getPageSize() * ($queryCondition->getCurrentPage()-1))
            ->setMaxResults($queryCondition->getPageSize())
            ->orderBy(sprintf(self::MODEL_ALIAS.'.%s',$queryCondition->getOrderBy()), $queryCondition->getOrderDirection());


        $paginator = new Paginator($queryBuilder->getQuery(), $fetchJoinCollections);
        $total = $paginator->count();
        $pages = (int) ceil($total/$queryCondition->getPageSize());

        return new PaginatedQueryResponse(
            $total,
            $pages,
            $queryCondition->getCurrentPage(),
            $paginator->getIterator()
        );

    }

    private function search(WorkplaceFilter $filter): QueryBuilder
    {
        $queryBuilder = $this->objectRepository->createQueryBuilder(self::MODEL_ALIAS);

        if(!empty($filter->getFilterByName())){
            $queryBuilder->andWhere(
                $queryBuilder->expr()->like(self::MODEL_ALIAS.'.name', ':name'))
                ->setParameter(
                    ':name',
                    '%'.$filter->getFilterByName().'%'
                );
        }

        if(!empty($filter->getFilterById())){
            $queryBuilder->andWhere(self::MODEL_ALIAS.'.id = :id')
                ->setParameter(
                    ':id',
                    $filter->getFilterById()
                );
        }

        if(!empty($filter->getFilterByCompanyId())){
            $queryBuilder->andWhere(self::MODEL_ALIAS.'.company = :companyId')
                ->setParameter(
                    ':companyId',
                    $filter->getFilterByCompanyId()
                );
        }

        return $queryBuilder;
    }

}