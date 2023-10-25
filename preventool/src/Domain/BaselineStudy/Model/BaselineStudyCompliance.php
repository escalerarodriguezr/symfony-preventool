<?php
declare(strict_types=1);

namespace Preventool\Domain\BaselineStudy\Model;

use Preventool\Domain\Admin\Model\Admin;
use Preventool\Domain\BaselineStudy\Model\Value\BaselineIndicatorCategory;
use Preventool\Domain\Shared\Model\AggregateRoot;
use Preventool\Domain\Shared\Model\Value\CompliancePercentage;
use Preventool\Domain\Shared\Model\Value\Uuid;
use Preventool\Domain\Workplace\Model\Workplace;

class BaselineStudyCompliance extends AggregateRoot
{
    private string $id;
    private Workplace $workplace;
    private int $totalCompliance;
    private int $compromisoCompliance;
    private int $politicaCompliance;
    private int $planeamientoCompliance;
    private int $implementacionCompliance;
    private int $evaluacionCompliance;
    private int $verificacionCompliance;
    private int $controlCompliance;
    private int $revisionCompliance;

    private ?Admin $creatorAdmin;
    private ?Admin $updaterAdmin;

    public function __construct(
        Uuid                 $id,
        Workplace            $workplace,
        CompliancePercentage $totalCompliance,
        CompliancePercentage $compromisoCompliance,
        CompliancePercentage $politicaCompliance,
        CompliancePercentage $planeamientoCompliance,
        CompliancePercentage $implementacionCompliance,
        CompliancePercentage $evaluacionCompliance,
        CompliancePercentage $verificacionCompliance,
        CompliancePercentage $controlCompliance,
        CompliancePercentage $revisionCompliance
    )
    {
        parent::__construct();
        $this->id = $id->value;
        $this->workplace = $workplace;
        $this->totalCompliance = $totalCompliance->value;
        $this->compromisoCompliance = $compromisoCompliance->value;
        $this->politicaCompliance = $politicaCompliance->value;
        $this->planeamientoCompliance = $planeamientoCompliance->value;
        $this->implementacionCompliance = $implementacionCompliance->value;
        $this->evaluacionCompliance = $evaluacionCompliance->value;
        $this->verificacionCompliance = $verificacionCompliance->value;
        $this->controlCompliance = $controlCompliance->value;
        $this->revisionCompliance = $revisionCompliance->value;
    }


    public function getId(): Uuid
    {
        return new Uuid($this->id);
    }

    public function getWorkplace(): Workplace
    {
        return $this->workplace;
    }

    public function setWorkplace(Workplace $workplace): void
    {
        $this->workplace = $workplace;
    }

    public function getTotalCompliance(): CompliancePercentage
    {
        return new CompliancePercentage($this->totalCompliance);
    }

    /**
     * @param int $totalCompliance
     */
    public function setTotalCompliance(CompliancePercentage $totalCompliance): self
    {
        $this->totalCompliance = $totalCompliance->value;
        return $this;
    }

    public function getCompromisoCompliance(): CompliancePercentage
    {
        return new CompliancePercentage($this->compromisoCompliance);
    }

    public function setCompromisoCompliance(CompliancePercentage $compromisoCompliance): self
    {
        $this->compromisoCompliance = $compromisoCompliance->value;
        return $this;
    }

    public function getPoliticaCompliance(): CompliancePercentage
    {
        return new CompliancePercentage($this->politicaCompliance);
    }

    public function setPoliticaCompliance(CompliancePercentage $politicaCompliance): self
    {
        $this->politicaCompliance = $politicaCompliance->value;
        return $this;
    }

    public function getPlaneamientoCompliance(): CompliancePercentage
    {
        return new CompliancePercentage($this->planeamientoCompliance);
    }

    public function setPlaneamientoCompliance(CompliancePercentage $planeamientoCompliance): self
    {
        $this->planeamientoCompliance = $planeamientoCompliance->value;
        return $this;
    }

    public function getImplementacionCompliance(): CompliancePercentage
    {
        return new CompliancePercentage($this->implementacionCompliance);
    }

    public function setImplementacionCompliance(CompliancePercentage $implementacionCompliance): self
    {
        $this->implementacionCompliance = $implementacionCompliance->value;
        return $this;
    }

    public function getEvaluacionCompliance(): CompliancePercentage
    {
        return new CompliancePercentage($this->evaluacionCompliance);
    }

    public function setEvaluacionCompliance(CompliancePercentage $evaluacionCompliance): self
    {
        $this->evaluacionCompliance = $evaluacionCompliance->value;
        return $this;
    }

    public function getVerificacionCompliance(): CompliancePercentage
    {
        return new CompliancePercentage($this->verificacionCompliance);
    }

    public function setVerificacionCompliance(CompliancePercentage $verificacionCompliance): self
    {
        $this->verificacionCompliance = $verificacionCompliance->value;
        return $this;
    }

    public function getControlCompliance(): CompliancePercentage
    {
        return new CompliancePercentage($this->controlCompliance);
    }

    public function setControlCompliance(CompliancePercentage $controlCompliance): self
    {
        $this->controlCompliance = $controlCompliance->value;
        return $this;

    }

    public function getRevisionCompliance(): CompliancePercentage
    {
        return new CompliancePercentage($this->revisionCompliance);
    }

    public function setRevisionCompliance(CompliancePercentage $revisionCompliance): self
    {
        $this->revisionCompliance = $revisionCompliance->value;
        return $this;
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


    public function recalculateByCategoryAndCategoryPercentage(
        BaselineIndicatorCategory $category,
        CompliancePercentage $categoryPercentage
    ): void
    {
        $setCategory = sprintf('set%sCompliance',ucfirst($category->value));

        $this->{$setCategory}($categoryPercentage);

        $total = $this->compromisoCompliance;
        $total += $this->politicaCompliance;
        $total += $this->planeamientoCompliance;
        $total += $this->implementacionCompliance;
        $total += $this->evaluacionCompliance;
        $total += $this->verificacionCompliance;
        $total += $this->controlCompliance;
        $total += $this->revisionCompliance;

        $percentage = floor($total/8);
        $percentage = intval($percentage);

        $this->setTotalCompliance(new CompliancePercentage($percentage));

    }


}