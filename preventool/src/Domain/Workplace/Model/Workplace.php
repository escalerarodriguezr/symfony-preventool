<?php
declare(strict_types=1);

namespace Preventool\Domain\Workplace\Model;

use Preventool\Domain\Admin\Model\Admin;
use Preventool\Domain\Company\Model\Company;
use Preventool\Domain\Company\Model\Value\Address;
use Preventool\Domain\Shared\Model\AggregateRoot;
use Preventool\Domain\Shared\Model\Value\Name;
use Preventool\Domain\Shared\Model\Value\Phone;
use Preventool\Domain\Shared\Model\Value\Uuid;

class Workplace extends AggregateRoot
{
    private string $id;
    private Company $company;
    private string $name;
    private string $contactPhone;
    private string $address;
    private int $numberOfWorkers;
    private bool $active;
    private ?Admin $creatorAdmin;
    private ?Admin $updaterAdmin;

    /**
     * @param string $id
     */
    public function __construct(
        Uuid $id,
        Company $company,
        Name $name,
        Phone $contactPhone,
        Address $address,
        int $numberOfWorkers
    )
    {
        parent::__construct();
        $this->id = $id->value;
        $this->company = $company;
        $this->name = $name->value;
        $this->contactPhone = $contactPhone->value;
        $this->address = $address->value;
        $this->numberOfWorkers = $numberOfWorkers;
        $this->active = true;
    }


    public function getId(): Uuid
    {
        return new Uuid($this->id);
    }

    public function getCompany(): Company
    {
        return $this->company;
    }

    public function setCompany(Company $company): void
    {
        $this->company = $company;
    }

    public function getName(): Name
    {
        return new Name($this->name);
    }

    public function setName(Name $name): void
    {
        $this->name = $name->value;
    }

    public function getContactPhone(): Phone
    {
        return new Phone($this->contactPhone);
    }

    public function setContactPhone(Phone $contactPhone): void
    {
        $this->contactPhone = $contactPhone->value;
    }

    public function getAddress(): Address
    {
        return new Address($this->address);
    }

    public function setAddress(Address $address): void
    {
        $this->address = $address->value;
    }

    public function getNumberOfWorkers(): int
    {
        return $this->numberOfWorkers;
    }

    public function setNumberOfWorkers(int $numberOfWorkers): void
    {
        $this->numberOfWorkers = $numberOfWorkers;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function setActive(bool $active): void
    {
        $this->active = $active;
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