<?php
declare(strict_types=1);

namespace Preventool\Infrastructure\Ui\Http\Request\DTO\OccupationalRisk;

use Preventool\Infrastructure\Ui\Http\Request\RequestDTO;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Validator\Constraints\Type;

class CalculateTaskRiskAssessmentRequest implements RequestDTO
{

    const SEVERITY_INDEX = 'severityIndex';
    const PEOPLE_EXPOSED_INDEX = 'peopleExposedIndex';
    const PROCEDURE_INDEX = 'procedureIndex';
    const TRAINING_INDEX = 'trainingIndex';
    const EXPOSURE_INDEX = 'exposureIndex';

    #[NotBlank]
    #[Type(type: 'integer')]
    #[Range(min: 1,max: 3)]
    private mixed $severityIndex;

    #[NotBlank]
    #[Type(type: 'integer')]
    #[Range(min: 1,max: 3)]
    private mixed $peopleExposedIndex;

    #[NotBlank]
    #[Type(type: 'integer')]
    #[Range(min: 1,max: 3)]
    private mixed $procedureIndex;

    #[NotBlank]
    #[Type(type: 'integer')]
    #[Range(min: 1,max: 3)]
    private mixed $trainingIndex;

    #[NotBlank]
    #[Type(type: 'integer')]
    #[Range(min: 1,max: 3)]
    private mixed $exposureIndex;



    public function __construct(Request $request)
    {
        $payload = json_decode($request->getContent(),true);
        $this->severityIndex = $payload[self::SEVERITY_INDEX] ?? null;
        $this->peopleExposedIndex = $payload[self::PEOPLE_EXPOSED_INDEX] ?? null;
        $this->procedureIndex = $payload[self::PROCEDURE_INDEX] ?? null;
        $this->trainingIndex = $payload[self::TRAINING_INDEX] ?? null;
        $this->exposureIndex = $payload[self::EXPOSURE_INDEX] ?? null;
    }

    public function getSeverityIndex(): int
    {
        return $this->severityIndex;
    }

    public function getPeopleExposedIndex(): int
    {
        return $this->peopleExposedIndex;
    }

    public function getProcedureIndex(): int
    {
        return $this->procedureIndex;
    }

    public function getTrainingIndex(): int
    {
        return $this->trainingIndex;
    }

    public function getExposureIndex(): int
    {
        return $this->exposureIndex;
    }


}