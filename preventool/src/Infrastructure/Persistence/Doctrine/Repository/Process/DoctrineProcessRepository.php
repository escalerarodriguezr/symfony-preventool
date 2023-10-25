<?php
declare(strict_types=1);

namespace Preventool\Infrastructure\Persistence\Doctrine\Repository\Process;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Preventool\Domain\Process\Exception\ProcessAlreadyExistsException;
use Preventool\Domain\Process\Exception\ProcessNotFoundException;
use Preventool\Domain\Process\Model\Process;
use Preventool\Domain\Process\Repository\ProcessFilter;
use Preventool\Domain\Process\Repository\ProcessRepository;
use Preventool\Domain\Shared\Model\Value\LongName;
use Preventool\Domain\Shared\Model\Value\Uuid;
use Preventool\Domain\Shared\Repository\QueryCondition\QueryCondition;
use Preventool\Domain\Shared\Repository\Response\PaginatedQueryResponse;
use Preventool\Domain\Workplace\Model\Workplace;
use Preventool\Infrastructure\Persistence\Doctrine\Repository\DoctrineBaseRepository;

class DoctrineProcessRepository extends DoctrineBaseRepository implements ProcessRepository
{
    const MODEL_ALIAS = 'p';
    protected static function entityClass(): string
    {
        return Process::class;
    }

    public function save(Process $model): void
    {
        try {
            $this->saveEntity($model);

        }catch (UniqueConstraintViolationException $exception){
            throw ProcessAlreadyExistsException::withNameForWorkplace(
                $model->getName(),
                $model->getWorkplace()
            );
        }
    }

    public function delete(Process $model): void
    {
        $this->removeEntity($model);
    }


    public function findById(
        Uuid $id
    ): Process
    {
        $criteria = [
            'id' => $id->value,
        ];

        $process = $this->objectRepository->findOneBy($criteria);

        if($process === null){
            throw ProcessNotFoundException::withId(
                $id
            );
        }

        return $process;
    }

    public function findByWorkplaceAndId(
        Workplace $workplace,
        Uuid $id
    ): Process
    {
        $criteria = [
            'id' => $id->value,
            'workplace' => $workplace->getId()->value
        ];

        $process = $this->objectRepository->findOneBy($criteria);

        if($process === null){
            throw ProcessNotFoundException::withIdForWorkplace(
                $workplace,
                $id
            );
        }

        return $process;
    }

    public function findByWorkplaceAndNameOrNull(
        Workplace $workplace,
        LongName $name
    ): ?Process
    {
        $criteria = [
            'name' => $name->value,
            'workplace' => $workplace->getId()->value
        ];

        return $this->objectRepository->findOneBy($criteria);

    }


    public function searchPaginated(
        QueryCondition $queryCondition,
        ProcessFilter $filter,
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

    private function search(ProcessFilter $filter): QueryBuilder
    {
        $queryBuilder = $this->objectRepository->createQueryBuilder(self::MODEL_ALIAS);

        if(!empty($filter->filterByName)){
            $queryBuilder->andWhere(
                $queryBuilder->expr()->like(self::MODEL_ALIAS.'.name', ':name'))
                ->setParameter(
                    ':name',
                    '%'.$filter->filterByName.'%'
                );
        }

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

        return $queryBuilder;
    }


}