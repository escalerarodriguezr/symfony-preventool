<?php
declare(strict_types=1);

namespace Preventool\Infrastructure\Persistence\Doctrine\Repository\BaselineStudy;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Preventool\Domain\BaselineStudy\Exception\BaselineStudyAlreadyExistsException;
use Preventool\Domain\BaselineStudy\Exception\BaselineStudyNotFoundException;
use Preventool\Domain\BaselineStudy\Exception\WorkplaceBaselineStudyByCategoryNotFoundException;
use Preventool\Domain\BaselineStudy\Model\BaselineStudy;
use Preventool\Domain\BaselineStudy\Model\Value\BaselineIndicatorCategory;
use Preventool\Domain\BaselineStudy\Repository\BaselineStudyRepository;
use Preventool\Domain\Shared\Model\Value\Uuid;
use Preventool\Domain\Workplace\Model\Workplace;
use Preventool\Infrastructure\Persistence\Doctrine\Repository\DoctrineBaseRepository;

class DoctrineBaselineStudyRepository extends DoctrineBaseRepository implements BaselineStudyRepository
{
    protected static function entityClass(): string
    {
        return BaselineStudy::class;
    }

    public function save(BaselineStudy $model): void
    {
        try {
            $this->saveEntity($model);

        }catch (UniqueConstraintViolationException $exception){

            throw BaselineStudyAlreadyExistsException::forWorkplace($model->getWorkplace());
        }

    }

    public function findById(Uuid $id): BaselineStudy
    {
        $criteria = [
            'id' => $id->value
        ];
        $model = $this->objectRepository->findOneBy($criteria);

        if($model === null){
            throw BaselineStudyNotFoundException::withId($id);
        }

        return $model;
    }


    public function findAllByWorkplace(Workplace $workplace): array
    {
        $array = $this->objectRepository->findBy([
            'workplace' => $workplace->getId()->value
        ]);

        if( !count($array)){
            throw BaselineStudyNotFoundException::fotWorkplace($workplace);
        }

        return $array;
    }

    public function findAllByWorkplaceAndCategory(
        Workplace $workplace,
        BaselineIndicatorCategory $category
    ) : array
    {
        $criteria = [
            'workplace' => $workplace->getId()->value,
            'category' => $category->value
        ];
        $orderBy = [
            'indicator' => 'ASC'
        ];

        $array = $this->objectRepository->findBy(
            $criteria,
            $orderBy
        );

        if( !count($array)){
            throw WorkplaceBaselineStudyByCategoryNotFoundException::forWorkplaceAndCategory(
                $workplace,
                $category
            );
        }

        return $array;
    }

    public function findByWorkplaceAndIndicator(
        Workplace $workplace,
        string $indicator
    ): BaselineStudy
    {
        $criteria = [
            'workplace' => $workplace->getId()->value,
            'indicator' => $indicator
        ];

        $model = $this->objectRepository->findOneBy($criteria);

        if( $model === null ){
            throw BaselineStudyNotFoundException::forWorkplaceAndIndicator(
                $workplace,
                $indicator
            );
        }

        return $model;
    }


}