<?php
declare(strict_types=1);

namespace Preventool\Infrastructure\Persistence\Doctrine\Repository\Admin;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Preventool\Domain\Admin\Exception\AdminAlreadyExistsException;
use Preventool\Domain\Admin\Exception\AdminNotFoundException;
use Preventool\Domain\Admin\Model\Admin;
use Preventool\Domain\Admin\Repository\AdminFilter;
use Preventool\Domain\Admin\Repository\AdminRepository;
use Preventool\Domain\Shared\Model\Value\Email;
use Preventool\Domain\Shared\Model\Value\Uuid;
use Preventool\Domain\Shared\Repository\QueryCondition\QueryCondition;
use Preventool\Domain\Shared\Repository\Response\PaginatedQueryResponse;
use Preventool\Infrastructure\Persistence\Doctrine\Repository\DoctrineBaseRepository;

class DoctrineAdminRepository extends DoctrineBaseRepository implements AdminRepository
{
    protected static function entityClass(): string
    {
        return Admin::class;
    }

    public function save(Admin $admin): void
    {
        try {
            $this->saveEntity($admin);
        }catch (UniqueConstraintViolationException $exception){
            throw AdminAlreadyExistsException::withEmail($admin->getEmail());
        }
    }

    public function findById(Uuid $id): Admin
    {
        $admin = $this->objectRepository->findOneBy(['id' => $id->value]);
        if(null === $admin) {
            throw AdminNotFoundException::withId($id);
        }

        return $admin;
    }

    public function findByEmailOrNull(Email $email): ?Admin
    {
        return $this->objectRepository->findOneBy(
            [
                'email' => $email->value
            ]
        );
    }


    public function searchPaginated(
        QueryCondition $queryCondition,
        AdminFilter $filter,
        $fetchJoinCollections = false
    ): PaginatedQueryResponse
    {
        $queryBuilder = $this->search($filter);
        $queryBuilder
            ->setFirstResult($queryCondition->getPageSize() * ($queryCondition->getCurrentPage()-1))
            ->setMaxResults($queryCondition->getPageSize())
            ->orderBy(sprintf('a.%s',$queryCondition->getOrderBy()), $queryCondition->getOrderDirection());


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

    private function search(AdminFilter $filter): QueryBuilder
    {
        $queryBuilder = $this->objectRepository->createQueryBuilder('a');

        if(!empty($filter->getFilterByEmail())){
            $queryBuilder->andWhere(
                $queryBuilder->expr()->like('a.email', ':email'))
                ->setParameter(
                    ':email',
                    '%'.$filter->getFilterByEmail().'%'
                );
        }

        if(!empty($filter->getFilterById())){
            $queryBuilder->andWhere('a.id = :id')
                ->setParameter(
                    ':id',
                    $filter->getFilterById()
                );
        }

        if( !empty($filter->getFilterByCreatedAtFrom()) ){
            $queryBuilder->andWhere
            (
                $queryBuilder->expr()->gte('a.createdAt', ':createdAtFrom')
            )
                ->setParameter(':createdAtFrom', $filter->getFilterByCreatedAtFrom());
        }

        if( !empty($filter->getFilterByCreatedAtTo()) ){
            $queryBuilder->andWhere
            (
                $queryBuilder->expr()->lte('a.createdAt', ':createdAtTo')
            )
                ->setParameter(':createdAtTo', $filter->getFilterByCreatedAtTo());
        }

        return $queryBuilder;
    }


}