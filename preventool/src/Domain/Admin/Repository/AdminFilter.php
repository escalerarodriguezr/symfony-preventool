<?php
declare(strict_types=1);

namespace Preventool\Domain\Admin\Repository;

class AdminFilter
{


    public function __construct(
        private ?string $filterById = null,
        private ?string $filterByEmail = null,
        private ?string $filterByCreatedAtFrom = null,
        private ?string $filterByCreatedAtTo = null
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

    public function getFilterByEmail(): ?string
    {
        return $this->filterByEmail;
    }

    public function setFilterByEmail(?string $filterByEmail): void
    {
        $this->filterByEmail = $filterByEmail;
    }

    /**
     * @return string|null
     */
    public function getFilterByCreatedAtFrom(): ?string
    {
        return $this->filterByCreatedAtFrom;
    }

    /**
     * @param string|null $filterByCreatedAtFrom
     */
    public function setFilterByCreatedAtFrom(?string $filterByCreatedAtFrom): void
    {
        $this->filterByCreatedAtFrom = $filterByCreatedAtFrom;
    }

    public function getFilterByCreatedAtTo(): ?string
    {
        return $this->filterByCreatedAtTo;
    }

    public function setFilterByCreatedAtTo(?string $filterByCreatedAtTo): void
    {
        $this->filterByCreatedAtTo = $filterByCreatedAtTo;
    }
}