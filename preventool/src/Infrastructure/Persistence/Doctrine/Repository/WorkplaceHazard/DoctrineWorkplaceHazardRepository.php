<?php
declare(strict_types=1);

namespace Preventool\Infrastructure\Persistence\Doctrine\Repository\WorkplaceHazard;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Preventool\Domain\OccupationalRisk\Model\TaskHazard;
use Preventool\Domain\Process\Repository\ProcessFilter;
use Preventool\Domain\Shared\Model\Value\Uuid;
use Preventool\Domain\Shared\Repository\QueryCondition\QueryCondition;
use Preventool\Domain\Shared\Repository\Response\PaginatedQueryResponse;
use Preventool\Domain\WorkplaceHazard\Exception\WorkplaceHazardAlreadyExistsException;
use Preventool\Domain\WorkplaceHazard\Exception\WorkplaceHazardNotFoundException;
use Preventool\Domain\WorkplaceHazard\Model\WorkplaceHazard;
use Preventool\Domain\WorkplaceHazard\Repository\WorkplaceHazardFilter;
use Preventool\Domain\WorkplaceHazard\Repository\WorkplaceHazardRepository;
use Preventool\Infrastructure\Persistence\Doctrine\Repository\DoctrineBaseRepository;


class DoctrineWorkplaceHazardRepository extends DoctrineBaseRepository implements WorkplaceHazardRepository
{
    const MODEL_ALIAS = 'wh';
    protected static function entityClass(): string
    {
        return WorkplaceHazard::class;
    }

    public function save(WorkplaceHazard $model): void
    {
        try {
            $this->saveEntity($model);
        }catch (UniqueConstraintViolationException $exception){
            throw WorkplaceHazardAlreadyExistsException::withNameForWorkplace(
                $model->getName(),
                $model->getWorkplace()->getId()
            );
        }
    }

    public function findById(Uuid $id): WorkplaceHazard
    {
        $criteria = [
            'id' => $id->value
        ];

        $model = $this->objectRepository->findOneBy($criteria);
        if($model === null){
            throw WorkplaceHazardNotFoundException::withId($id);
        }
        return $model;
    }

    public function searchPaginated(
        QueryCondition $queryCondition,
        WorkplaceHazardFilter $filter,
        bool $fetchJoinCollections = false
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

    private function search(WorkplaceHazardFilter $filter): QueryBuilder
    {
        $queryBuilder = $this->objectRepository->createQueryBuilder(self::MODEL_ALIAS);

        $queryBuilder->select(sprintf('%s', self::MODEL_ALIAS));
        if(!empty($filter->filterById)){
            $queryBuilder->andWhere(self::MODEL_ALIAS.'.id = :id')
                ->setParameter(
                    ':id',
                    $filter->filterById
                );
        }

        if(!empty($filter->filterByWorkplaceId)){
            $queryBuilder->andWhere(self::MODEL_ALIAS.'.workplace = :workplaceId')
                ->setParameter(
                    ':workplaceId',
                    $filter->filterByWorkplaceId
                );
        }

//        if(!empty($filter->filterByNotHasTaskHazardWithTaskId)){
//
//            $queryBuilder->leftJoin(
//                sprintf('%s.%s', self::MODEL_ALIAS, 'taskHazards'),
//                'th'
//            );
//
//            $queryBuilder->andWhere(
//                $queryBuilder->expr()->orX(
//                    $queryBuilder->expr()->neq('th.task', ':taskId'),
//                    $queryBuilder
//                        ->expr()->isNull('th.id')
//                )
//
//            )->setParameter(
//                ':taskId',
//                $filter->filterByNotHasTaskHazardWithTaskId
//            );
//        }

        //subquery1
//        if(!empty($filter->filterByNotHasTaskHazardWithTaskId)){
//            $em = $this->getEntityManager();
//            $subQueryTaskHazard = $em->createQuery(
//                'SELECT subh.id
//                FROM Preventool\Domain\OccupationalRisk\Model\TaskHazard subth
//                JOIN subth.hazard subh
//                where subth.task = :taskId'
//            );
//
//
//            $queryBuilder->setParameter('taskId', $filter->filterByNotHasTaskHazardWithTaskId);
//            $queryBuilder->andWhere(
//                $queryBuilder->expr()->notIn(sprintf('%s.%s', self::MODEL_ALIAS,'id'), $subQueryTaskHazard->getDQL())
//            );
//
//        }



        return $queryBuilder;
    }


}