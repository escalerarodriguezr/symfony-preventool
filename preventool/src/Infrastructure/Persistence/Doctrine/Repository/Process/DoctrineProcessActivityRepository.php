<?php
declare(strict_types=1);

namespace Preventool\Infrastructure\Persistence\Doctrine\Repository\Process;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Preventool\Domain\Process\Exception\ProcessActivityAlreadyExistsException;
use Preventool\Domain\Process\Exception\ProcessActivityNotFoundException;
use Preventool\Domain\Process\Model\ProcessActivity;
use Preventool\Domain\Process\Repository\ProcessActivityFilter;
use Preventool\Domain\Process\Repository\ProcessActivityRepository;
use Preventool\Domain\Shared\Model\Value\Uuid;
use Preventool\Domain\Shared\Repository\Response\PaginatedQueryResponse;
use Preventool\Infrastructure\Persistence\Doctrine\Repository\DoctrineBaseRepository;
use Preventool\Domain\Shared\Repository\QueryCondition\QueryCondition;

class DoctrineProcessActivityRepository extends DoctrineBaseRepository implements ProcessActivityRepository
{

    const MODEL_ALIAS = 'pa';

    protected static function entityClass(): string
    {
        return ProcessActivity::class;
    }

    public function save(ProcessActivity $processActivity): void
    {
        try {
            $this->saveEntity($processActivity);
        }catch (UniqueConstraintViolationException $exception){
            throw ProcessActivityAlreadyExistsException::withNameForProcess(
                $processActivity->getName(),
                $processActivity->getProcess()
            );
        }
    }

    public function delete(ProcessActivity $processActivity): void
    {
        $this->removeEntity($processActivity);
    }


    public function findById(Uuid $id): ProcessActivity
    {
        $citeria = [
            'id' => $id->value
        ];

        $model = $this->objectRepository->findOneBy($citeria);

        if($model === null){
            throw ProcessActivityNotFoundException::withId($id);
        }

        return $model;
    }

    public function getAllByProcessId(Uuid $processId): array
    {
        $criteria = [
            'process' => $processId->value
        ];

        $order = [
            'activityOrder' => 'ASC'
        ];

        return $this->objectRepository->findBy(
            $criteria,
            $order
        );
    }


    public function searchPaginated(
        QueryCondition $queryCondition,
        ProcessActivityFilter $filter,
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

    private function search(ProcessActivityFilter $filter): QueryBuilder
    {
        $queryBuilder = $this->objectRepository->createQueryBuilder(self::MODEL_ALIAS);

        if(!empty($filter->filterById)){
            $queryBuilder->andWhere(self::MODEL_ALIAS.'.id = :id')
                ->setParameter(
                    ':id',
                    $filter->filterById
                );
        }

        if(!empty($filter->filterByProcessId)){
            $queryBuilder->andWhere(self::MODEL_ALIAS.'.process = :processId')
                ->setParameter(
                    ':processId',
                    $filter->filterByProcessId
                );
        }

        return $queryBuilder;
    }


}