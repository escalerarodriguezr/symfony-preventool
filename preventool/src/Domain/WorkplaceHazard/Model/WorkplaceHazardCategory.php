<?php
declare(strict_types=1);

namespace Preventool\Domain\WorkplaceHazard\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Preventool\Domain\Admin\Model\Admin;
use Preventool\Domain\Shared\Model\AggregateRoot;
use Preventool\Domain\Shared\Model\Value\MediumDescription;
use Preventool\Domain\Shared\Model\Value\Name;
use Preventool\Domain\Shared\Model\Value\Uuid;
use Preventool\Domain\Workplace\Model\Workplace;

class WorkplaceHazardCategory extends AggregateRoot
{
    private string $id;
    private Workplace $workplace;
    private string $name;
    private ?string $description;
    private bool $active;
    private ?Admin $creatorAdmin;
    private ?Admin $updaterAdmin;

    private Collection $workplaceHazards;

    public function __construct(
        Uuid $id,
        Workplace $workplace,
        Name $name
    )
    {
        parent::__construct();

        $this->id = $id->value;
        $this->workplace = $workplace;
        $this->name = $name->value;
        $this->active = true;
        $this->description = null;
        $this->workplaceHazards   = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getId(): Uuid
    {
        return new Uuid($this->id);
    }

    public function getWorkplace(): Workplace
    {
        return $this->workplace;
    }

    public function getName(): Name
    {
        return new Name($this->name);
    }

    public function setName(Name $name): void
    {
        $this->name = $name->value;
    }


    public function getDescription(): ?MediumDescription
    {
        return $this->description ? new MediumDescription($this->description) : null;
    }

    public function setDescription(?MediumDescription $description): void
    {
        $this->description = $description?->value;
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


    public function getWorkplaceHazards(): Collection
    {
        return $this->workplaceHazards;
    }

    public function addWorkplaceHazard(WorkplaceHazard $workplaceHazard): void
    {
        if ($this->workplaceHazards->contains($workplaceHazard)) {
            return;
        }

        $this->workplaceHazards->add($workplaceHazard);
    }




}