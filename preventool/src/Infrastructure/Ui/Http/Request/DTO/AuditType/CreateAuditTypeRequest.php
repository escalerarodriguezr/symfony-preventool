<?php
declare(strict_types=1);

namespace Preventool\Infrastructure\Ui\Http\Request\DTO\AuditType;

use Preventool\Infrastructure\Ui\Http\Request\RequestDTO;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class CreateAuditTypeRequest implements RequestDTO
{

    const NAME = 'name';
    const DESCRIPTION = 'description';
    const COMPANY_ID = 'companyId';
    const WORKPLACE_ID = 'workplaceId';



    #[Assert\NotBlank(
        message: "Missing or invalid request parameter 'name'."
    )]

    #[Assert\Length(
        min: 2,
        max: 100,
        minMessage: 'Name must be at least {{ limit }} characters long',
        maxMessage: 'Name cannot be longer than {{ limit }} characters',
    )]

    private mixed $name;


    #[Assert\Length(
        min: 2,
        max: 300,
        minMessage: 'Description must be at least {{ limit }} characters long',
        maxMessage: 'Description name cannot be longer than {{ limit }} characters',
    )]
    private mixed $description;

    #[Assert\Uuid(
        message: "CompanyId is not a valid UUID"
    )]
    private mixed $companyId;


    #[Assert\Uuid(
        message: "WorkplaceId is not a valid UUID"
    )]
    private mixed $workplaceId;


    public function __construct(
        Request $request
    )
    {
        $payload = $request->toArray();

        $this->name = $payload[self::NAME] ?? null;
        $this->description = $payload[self::DESCRIPTION] ?? null;
        $this->companyId = $payload[self::COMPANY_ID] ?? null;
        $this->workplaceId = $payload[self::WORKPLACE_ID] ?? null;
    }

    public function getName(): mixed
    {
        return $this->name;
    }

    public function getDescription(): mixed
    {
        return $this->description;
    }

    public function getCompanyId(): mixed
    {
        return $this->companyId;
    }

    public function getWorkplaceId(): mixed
    {
        return $this->workplaceId;
    }

}