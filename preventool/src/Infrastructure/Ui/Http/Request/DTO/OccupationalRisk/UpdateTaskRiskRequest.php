<?php
declare(strict_types=1);

namespace Preventool\Infrastructure\Ui\Http\Request\DTO\OccupationalRisk;

use Preventool\Infrastructure\Ui\Http\Request\RequestDTO;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UpdateTaskRiskRequest implements RequestDTO
{
    const NAME = 'name';
    const OBSERVATIONS = 'observations';
    const LEGAL_REQUIREMENT = 'legalRequirement';
    const HAZARD_NAME = 'hazardName';
    const HAZARD_DESCRIPTION = 'hazardDescription';

    #[NotBlank(allowNull: true)]
    #[Length(max: 100)]
    private mixed $name;

    #[Length(max: 1000)]
    private mixed $observations;

    #[Length(max: 300)]
    private mixed $legalRequirement;

    #[NotBlank(allowNull: true)]
    #[Length(max: 50)]
    private mixed $hazardName;

    #[Length(max: 300)]
    private mixed $hazardDescription;


    public function __construct(Request $request)
    {
        $payload = json_decode($request->getContent(),true);

        $this->name = $payload[self::NAME] ?? null;
        $this->observations = $payload[self::OBSERVATIONS] ?? null;
        $this->legalRequirement = $payload[self::LEGAL_REQUIREMENT] ?? null;
        $this->hazardName = $payload[self::HAZARD_NAME] ?? null;
        $this->hazardDescription = $payload[self::HAZARD_DESCRIPTION] ?? null;

    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getObservations(): ?string
    {
        return $this->observations;
    }

    public function getLegalRequirement(): ?string
    {
        return $this->legalRequirement;
    }

    public function getHazardName(): ?string
    {
        return $this->hazardName;
    }

    public function getHazardDescription(): ?string
    {
        return $this->hazardDescription;
    }


}