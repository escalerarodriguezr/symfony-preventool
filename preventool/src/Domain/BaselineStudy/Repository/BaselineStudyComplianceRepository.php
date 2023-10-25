<?php
declare(strict_types=1);

namespace Preventool\Domain\BaselineStudy\Repository;

use Preventool\Domain\BaselineStudy\Model\BaselineStudyCompliance;
use Preventool\Domain\Workplace\Model\Workplace;

interface BaselineStudyComplianceRepository
{
    public function save(BaselineStudyCompliance $model): void;
    public function findByWorkplace(Workplace $workplace): BaselineStudyCompliance;

}