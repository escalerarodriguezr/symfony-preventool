<?php
declare(strict_types=1);

namespace Preventool\Domain\BaselineStudy\Model;

use Preventool\Domain\Admin\Model\Admin;
use Preventool\Domain\BaselineStudy\Model\Value\BaselineIndicatorCategory;
use Preventool\Domain\Shared\Model\AggregateRoot;
use Preventool\Domain\Shared\Model\Value\CompliancePercentage;
use Preventool\Domain\Shared\Model\Value\MediumObservation;
use Preventool\Domain\Shared\Model\Value\Uuid;
use Preventool\Domain\Workplace\Model\Workplace;

class BaselineStudy extends AggregateRoot
{
    private string $id;
    private Workplace $workplace;
    private string $category;
    private string $indicator;
    private int $compliancePercentage;
    private ?string $observations;

    private ?Admin $creatorAdmin;
    private ?Admin $updaterAdmin;

    public function __construct(
        Uuid $id,
        Workplace $workplace,
        BaselineIndicatorCategory $category,
        string $indicator,
        CompliancePercentage $compliancePercentage
    )
    {
        parent::__construct();
        $this->id = $id->value;
        $this->workplace = $workplace;
        $this->category = $category->value;
        $this->indicator = $indicator;
        $this->compliancePercentage = $compliancePercentage->value;
        $this->observations = null;
    }


    public function getId(): Uuid
    {
        return new Uuid($this->id);
    }

    public function getWorkplace(): Workplace
    {
        return $this->workplace;
    }

    public function getCategory(): BaselineIndicatorCategory
    {
        return new BaselineIndicatorCategory($this->category);
    }


    public function getIndicator(): string
    {
        return $this->indicator;
    }


    public function getCompliancePercentage(): CompliancePercentage
    {
        return new CompliancePercentage($this->compliancePercentage);
    }

    public function setCompliancePercentage(CompliancePercentage $compliancePercentage): self
    {
        $this->compliancePercentage = $compliancePercentage->value;
        return $this;
    }

    public function getObservations(): ?MediumObservation
    {
        return $this->observations ? new MediumObservation($this->observations) : null;
    }

    public function setObservations(?MediumObservation $observations): self
    {
        $this->observations = $observations?->value;
        return $this;
    }

    public function getCreatorAdmin(): ?Admin
    {
        return $this->creatorAdmin;
    }


    public function setCreatorAdmin(?Admin $creatorAdmin): self
    {
        $this->creatorAdmin = $creatorAdmin;
        return  $this;
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