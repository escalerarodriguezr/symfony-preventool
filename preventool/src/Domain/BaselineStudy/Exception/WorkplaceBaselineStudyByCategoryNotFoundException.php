<?php
declare(strict_types=1);

namespace Preventool\Domain\BaselineStudy\Exception;

use Preventool\Domain\BaselineStudy\Model\Value\BaselineIndicatorCategory;
use Preventool\Domain\Workplace\Model\Workplace;

class WorkplaceBaselineStudyByCategoryNotFoundException extends \DomainException
{
    public static function forWorkplaceAndCategory(
        Workplace $workplace,
        BaselineIndicatorCategory $category
    ): self
    {
        return new self(
            sprintf(
                'BaselineStudy of workplace %s and category %s not found',
                $workplace->getId()->value,
                $category->value
            )
        );
    }

}