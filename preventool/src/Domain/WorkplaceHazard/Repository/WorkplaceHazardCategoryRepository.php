<?php

namespace Preventool\Domain\WorkplaceHazard\Repository;

use Preventool\Domain\WorkplaceHazard\Model\WorkplaceHazardCategory;

interface WorkplaceHazardCategoryRepository
{
    public function save(WorkplaceHazardCategory $model): void;

}