<?php
declare(strict_types=1);

namespace Preventool\Domain\Workplace\Repository;

class WorkplaceFilter
{
    public function __construct(
        private ?string $filterById = null,
        private ?string $filterByCompanyId = null,
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

    public function getFilterByCompanyId(): ?string
    {
        return $this->filterByCompanyId;
    }

    public function setFilterByCompanyId(?string $filterByCompanyId): void
    {
        $this->filterByCompanyId = $filterByCompanyId;
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