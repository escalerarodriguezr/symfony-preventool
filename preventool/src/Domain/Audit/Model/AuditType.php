<?php
declare(strict_types=1);

namespace Preventool\Domain\Audit\Model;

use Preventool\Domain\Admin\Model\Admin;
use Preventool\Domain\Audit\Model\Value\AuditTypeScope;
use Preventool\Domain\Company\Model\Company;
use Preventool\Domain\Shared\Model\AggregateRoot;
use Preventool\Domain\Shared\Model\Value\MediumDescription;
use Preventool\Domain\Shared\Model\Value\Name;
use Preventool\Domain\Shared\Model\Value\Uuid;
use Preventool\Domain\Workplace\Model\Workplace;

class AuditType extends AggregateRoot
{
    private string $id;
    private ?Company $company;
    private ?Workplace $workplace;
    private string $scope;
    private string $name;
    private ?string $description;
    private bool $active;
    private ?Admin $creatorAdmin;
    private ?Admin $updaterAdmin;

    public function __construct(
        Uuid $uuid,
        AuditTypeScope $scope,
        Name $name,
    )
    {
        parent::__construct();

        $this->id = $uuid->value;
        $this->scope = $scope->value;
        $this->name = $name->value;
        $this->active = true;
    }

    public function getId(): Uuid
    {
        return new Uuid($this->id);
    }

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): self
    {
        $this->company = $company;
        return $this;
    }

    public function getWorkplace(): ?Workplace
    {
        return $this->workplace;
    }

    public function setWorkplace(?Workplace $workplace): self
    {
        $this->workplace = $workplace;
        return $this;
    }

    public function getName(): Name
    {
        return new Name($this->name);
    }

    public function setName(Name $name): self
    {
        $this->name = $name->value;
        return $this;
    }

    public function getScope(): AuditTypeScope
    {
        return new AuditTypeScope($this->scope);
    }

    /**
     * @param AuditTypeScope $scope
     */
    public function setScope(AuditTypeScope $scope): self
    {
        $this->scope = $scope->value;
        return $this;
    }



    public function getDescription(): ?MediumDescription
    {
        return $this->description ? new MediumDescription($this->description) : null;
    }

    public function setDescription(?MediumDescription $description): self
    {
        $this->description = $description->value;
        return $this;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;
        return $this;
    }

    public function getCreatorAdmin(): ?Admin
    {
        return $this->creatorAdmin;
    }

    public function setCreatorAdmin(?Admin $creatorAdmin): self
    {
        $this->creatorAdmin = $creatorAdmin;
        return $this;
    }

    public function getUpdaterAdmin(): ?Admin
    {
        return $this->updaterAdmin;
    }

    public function setUpdaterAdmin(?Admin $updaterAdmin): self
    {
        $this->updaterAdmin = $updaterAdmin;
        return $this;
    }


}