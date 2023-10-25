<?php
declare(strict_types=1);

namespace Preventool\Domain\Company\Model;

use Preventool\Domain\Admin\Model\Admin;
use Preventool\Domain\Shared\Model\AggregateRoot;
use Preventool\Domain\Shared\Model\Value\DocumentStatus;
use Preventool\Domain\Shared\Model\Value\Uuid;


class HealthAndSafetyPolicy extends AggregateRoot
{
    private string $id;
    private Company $company;
    private string $status;
    private bool $active;
    private ?string $documentResource;
    private ?Admin $approvedAdmin;
    private ?Admin $creatorAdmin;
    private ?Admin $updaterAdmin;

    public function __construct(
        Uuid $id,
        Company $company,
        DocumentStatus $status,
    )
    {
        parent::__construct();
        $this->id = $id->value;
        $this->company = $company;
        $this->status = $status->value;
        $this->active = true;
    }


    public function getId(): Uuid
    {
        return new Uuid($this->id);
    }

    public function setId(Uuid $id): void
    {
        $this->id = $id->value;
    }

    public function getCompany(): Company
    {
        return $this->company;
    }

    public function setCompany(Company $company): void
    {
        $this->company = $company;
    }

    public function getStatus(): DocumentStatus
    {
        return new DocumentStatus($this->status);
    }

    public function setStatus(DocumentStatus $status): void
    {
        $this->status = $status->value;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function setActive(bool $active): void
    {
        $this->active = $active;
    }

    public function getDocumentResource(): ?string
    {
        return $this->documentResource;
    }

    public function setDocumentResource(?string $documentResource): void
    {
        $this->documentResource = $documentResource;
    }

    public function getApprovedAdmin(): ?Admin
    {
        return $this->approvedAdmin;
    }


    public function setApprovedAdmin(?Admin $approvedAdmin): void
    {
        $this->approvedAdmin = $approvedAdmin;
    }

    public function getCreatorAdmin(): ?Admin
    {
        return $this->creatorAdmin;
    }

    public function setCreatorAdmin(?Admin $creatorAdmin): void
    {
        $this->creatorAdmin = $creatorAdmin;
    }

    public function getUpdaterAdmin(): ?Admin
    {
        return $this->updaterAdmin;
    }

    public function setUpdaterAdmin(?Admin $updaterAdmin): void
    {
        $this->updaterAdmin = $updaterAdmin;
    }


}