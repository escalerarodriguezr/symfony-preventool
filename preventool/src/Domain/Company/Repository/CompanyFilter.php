<?php
declare(strict_types=1);

namespace Preventool\Domain\Company\Repository;

class CompanyFilter
{
    public function __construct(
        private ?string $filterById = null,
        private ?string $filterByName = null,
    )
    {
    }

    public function getFilterById(): ?string
    {
        return $this->filterById;
    }

    public function setFilterById(?string $filterById): void
    {
        $this->filterById = $filterById;
    }

    public function getFilterByName(): ?string
    {
        return $this->filterByName;
    }

    public function setFilterByName(?string $filterByName): void
    {
        $this->filterByName = $filterByName;
    }

}