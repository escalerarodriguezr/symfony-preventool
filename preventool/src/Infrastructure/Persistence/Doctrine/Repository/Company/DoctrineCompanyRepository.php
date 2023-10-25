<?php
declare(strict_types=1);

namespace Preventool\Infrastructure\Persistence\Doctrine\Repository\Company;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Preventool\Domain\Company\Exception\CompanyAlreadyExistsException;
use Preventool\Domain\Company\Exception\CompanyNotFoundException;
use Preventool\Domain\Company\Model\Company;
use Preventool\Domain\Company\Model\Value\LegalDocument;
use Preventool\Domain\Company\Repository\CompanyFilter;
use Preventool\Domain\Company\Repository\CompanyRepository;
use Preventool\Domain\Shared\Model\Value\Uuid;
use Preventool\Domain\Shared\Repository\QueryCondition\QueryCondition;
use Preventool\Domain\Shared\Repository\Response\PaginatedQueryResponse;
use Preventool\Infrastructure\Persistence\Doctrine\Repository\DoctrineBaseRepository;

class DoctrineCompanyRepository extends DoctrineBaseRepository implements CompanyRepository
{
    protected static function entityClass(): string
    {
        return Company::class;
    }

    public function save(
        Company $company
    ): void
    {
        try {
            $this->saveEntity($company);
        }catch (UniqueConstraintViolationException $exception){
            throw CompanyAlreadyExistsException::withLegalDocument($company->getLegalDocument());
        }
    }

    public function delete(Company $company): void
    {
        $this->removeEntity($company);
    }


    public function findByLegalDocumentOrNull(
        LegalDocument $legalDocument
    ): ?Company
    {
        return $this->objectRepository->findOneBy([
            'legalDocument' => $legalDocument->value
        ]);
    }

    public function findById(Uuid $id): Company
    {
        if (null === $company = $this->objectRepository->findOneBy(['id' => $id->value])) {
            throw CompanyNotFoundException::withId($id);
        }

        return $company;
    }

    public function searchPaginated(
        QueryCondition $queryCondition,
        CompanyFilter $filter,
        bool $fetchJoinCollections=false
    ): PaginatedQueryResponse
    {
        $queryBuilder = $this->search($filter);
        $queryBuilder
            ->setFirstResult($queryCondition->getPageSize() * ($queryCondition->getCurrentPage()-1))
            ->setMaxResults($queryCondition->getPageSize())
            ->orderBy(sprintf('c.%s',$queryCondition->getOrderBy()), $queryCondition->getOrderDirection());


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

    private function search(CompanyFilter $filter): QueryBuilder
    {
        $queryBuilder = $this->objectRepository->createQueryBuilder('c');

        if(!empty($filter->getFilterByName())){
            $queryBuilder->andWhere(
                $queryBuilder->expr()->like('c.name', ':name'))
                ->setParameter(
                    ':name',
                    '%'.$filter->getFilterByName().'%'
                );
        }

        if(!empty($filter->getFilterById())){
            $queryBuilder->andWhere('c.id = :id')
                ->setParameter(
                    ':id',
                    $filter->getFilterById()
                );
        }

        return $queryBuilder;
    }

}