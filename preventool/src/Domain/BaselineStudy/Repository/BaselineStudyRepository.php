<?php
declare(strict_types=1);

namespace Preventool\Domain\BaselineStudy\Repository;

use Preventool\Domain\BaselineStudy\Model\BaselineStudy;
use Preventool\Domain\BaselineStudy\Model\Value\BaselineIndicatorCategory;
use Preventool\Domain\Shared\Model\Value\Uuid;
use Preventool\Domain\Workplace\Model\Workplace;

interface BaselineStudyRepository
{
    public function save(BaselineStudy $model): void;
    public function findById(Uuid $id): BaselineStudy;

    /**
     * @param Workplace $workplace
     * @return BaselineStudy[]
     */
    public function findAllByWorkplace(Workplace $workplace): array;

    public function findAllByWorkplaceAndCategory(
        Workplace $workplace,
        BaselineIndicatorCategory $category
    ): array;

    public function findByWorkplaceAndIndicator(
        Workplace $workplace,
        string $indicator
    ): BaselineStudy;

}