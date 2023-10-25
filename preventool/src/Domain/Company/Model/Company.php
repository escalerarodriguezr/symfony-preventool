<?php
declare(strict_types=1);

namespace Preventool\Domain\Company\Model;

use Preventool\Domain\Admin\Model\Admin;
use Preventool\Domain\Company\Model\Value\Address;
use Preventool\Domain\Company\Model\Value\LegalDocument;
use Preventool\Domain\Company\Model\Value\LegalName;
use Preventool\Domain\Company\Model\Value\Sector;
use Preventool\Domain\Shared\Model\AggregateRoot;
use Preventool\Domain\Shared\Model\Value\Name;
use Preventool\Domain\Shared\Model\Value\Uuid;

class Company extends AggregateRoot
{

    private string $id;
    private string $name;
    private string $legalName;
    private string $legalDocument;
    private string $address;
    private string $sector;
    private ?Admin $creatorAdmin;
    private ?Admin $updaterAdmin;
    private bool $active;

    public function __construct(
        Uuid $id,
        Name $name,
        LegalName $legalName,
        LegalDocument $legalDocument,
        Address $address,
        Sector $sector
    )
    {
        parent::__construct();
        $this->id = $id->value;
        $this->name = $name->value;
        $this->legalName = $legalName->value;
        $this->legalDocument = $legalDocument->value;
        $this->address = $address->value;
        $this->sector = $sector->value;
        $this->active = true;
    }

    public function getId(): Uuid
    {
        return new Uuid($this->id);
    }

    public function getName(): Name
    {
        return new Name($this->name);
    }

    public function getLegalName(): LegalName
    {
        return new LegalName($this->legalName);
    }

    public function getLegalDocument(): LegalDocument
    {
        return new LegalDocument($this->legalDocument);
    }

    public function getAddress(): Address
    {
        return new Address($this->address);
    }

    public function getSector(): Sector
    {
        return new Sector($this->sector);
    }

    public function getCreatorAdmin(): ?Admin
    {
        return $this->creatorAdmin;
    }

    public function getUpdaterAdmin(): ?Admin
    {
        return $this->updaterAdmin;
    }

    public function isActive(): bool
    {
        return $this->active;
    }


    public function setName(Name $name): void
    {
        $this->name = $name->value;
    }

    public function setLegalName(LegalName $legalName): void
    {
        $this->legalName = $legalName->value;
    }

    public function setLegalDocument(LegalDocument $legalDocument): void
    {
        $this->legalDocument = $legalDocument->value;
    }

    public function setAddress(Address $address): void
    {
        $this->address = $address->value;
    }

    public function setSector(Sector $sector): void
    {
        $this->sector = $sector->value;
    }

    public function setCreatorAdmin(?Admin $creatorAdmin): void
    {
        $this->creatorAdmin = $creatorAdmin;
    }

    public function setUpdaterAdmin(?Admin $updaterAdmin): void
    {
        $this->updaterAdmin = $updaterAdmin;
    }

    public function setActive(bool $active): void
    {
        $this->active = $active;
    }


}