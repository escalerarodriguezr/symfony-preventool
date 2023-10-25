<?php
declare(strict_types=1);

namespace Preventool\Infrastructure\Ui\Http\Request\DTO\BaselineStudy;

use Preventool\Infrastructure\Ui\Http\Request\RequestDTO;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class UpdateBaselineStudyIndicatorRequest implements RequestDTO
{
    const OBSERVATIONS = 'observations';
    const COMPLIANCE_PERCENTAGE = 'compliancePercentage';

    #[Assert\NotBlank(
        message: "Missing or invalid request parameter 'observations'.",
        allowNull: true
    )]

    #[Assert\Type(
        type: 'string',
        message: 'The observations value {{ value }} is not a valid {{ type }}.',
    )]

    #[Assert\Length(
        min: 1,
        max: 100,
        minMessage: 'observations must be at least {{ limit }} characters long',
        maxMessage: 'observations cannot be longer than {{ limit }} characters',
    )]
    private mixed $observations;


    #[Assert\NotBlank(
        message: "Missing or invalid request parameter 'compliancePercentage'.",
        allowNull: true
    )]
    #[Assert\Type(
        type: 'integer',
        message: 'The compliancePercentage value {{ value }} is not a valid {{ type }}.',
    )]
    #[Assert\Range(
        notInRangeMessage: 'You must be between {{ min }} % and {{ max }} % compliancePercentage to enter',
        min: 0,
        max: 100,
    )]
    private mixed $compliancePercentage;


    public function __construct(Request $request)
    {
        $payload = $request->toArray();

        $this->observations = $payload[self::OBSERVATIONS] ?? null;
        $this->compliancePercentage = $payload[self::COMPLIANCE_PERCENTAGE] ?? null;

    }

    public function getObservations(): ?string
    {
        return $this->observations;
    }

    public function getCompliancePercentage(): ?int
    {
        return $this->compliancePercentage;
    }

}