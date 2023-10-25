<?php

namespace Preventool\Infrastructure\Persistence\Doctrine\Repository\Traits;


use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Preventool\Domain\Audit\Repository\AuditTypeFilter;
use Preventool\Domain\Shared\Repository\QueryCondition\QueryCondition;
use Preventool\Domain\Shared\Repository\Response\PaginatedQueryResponse;

trait SharedQueryBuilder
{
    public function paginatedResponse(
        QueryBuilder $queryBuilder,
        QueryCondition $queryCondition,
        string $modelAlias,
        bool $fetchJoinCollections = false
    ): PaginatedQueryResponse
    {

        $queryBuilder
            ->setFirstResult($queryCondition->getPageSize() * ($queryCondition->getCurrentPage()-1))
            ->setMaxResults($queryCondition->getPageSize())
            ->orderBy(
                sprintf($modelAlias.'.%s',$queryCondition->getOrderBy()),
                $queryCondition->getOrderDirection()
            );


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

}