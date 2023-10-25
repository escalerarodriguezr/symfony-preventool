<?php
declare(strict_types=1);

namespace Preventool\Infrastructure\Ui\Http\Request\DTO\Company;

use Preventool\Infrastructure\Ui\Http\Request\RequestDTO;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class CreateCompanyRequest implements RequestDTO
{
    const NAME = 'name';
    const LEGAL_NAME = 'legalName';
    const LEGAL_DOCUMENT = 'legalDocument';
    const ADDRESS = 'address';
    const SECTOR = 'sector';



    /**
     * @Assert\NotBlank(message = "Missing or invalid request parameter 'name'.")
     * @Assert\Type(
     *     type="string",
     *     message = "Invalid value of request parameter 'name'."
     * )
     */
    private mixed $name;

    /**
     * @Assert\NotBlank(message = "Missing or invalid request parameter 'legalName'.")
     * @Assert\Type(
     *     type="string",
     *     message = "Invalid value of request parameter 'legalName'."
     * )
     */
    private mixed $legalName;

    /**
     * @Assert\NotBlank(message = "Missing or invalid request parameter 'name'.")
     * @Assert\Type(
     *     type="string",
     *     message = "Invalid value of request parameter 'legalDocument'."
     * )
     */
    private mixed $legalDocument;

    /**
     * @Assert\NotBlank(message = "Missing or invalid request parameter 'address'.")
     * @Assert\Type(
     *     type="string",
     *     message = "Invalid value of request parameter 'address'."
     * )
     */
    private mixed $address;

    /**
     * @Assert\NotBlank(message = "Missing or invalid request parameter 'sector'.")
     * @Assert\Type(
     *     type="string",
     *     message = "Invalid value of request parameter 'sector'."
     * )
     */
    private mixed $sector;


    public function __construct(
        Request $request
    )
    {
        $payload = $request->toArray();

        $this->name = $payload[self::NAME] ?? null;
        $this->legalName = $payload[self::LEGAL_NAME] ?? null;
        $this->legalDocument = $payload[self::LEGAL_DOCUMENT] ?? null;
        $this->address = $payload[self::ADDRESS] ?? null;
        $this->sector = $payload[self::SECTOR] ?? null;
    }


    public function getName(): string
    {
        return $this->name;
    }

    public function getLegalName(): string
    {
        return $this->legalName;
    }
    public function getLegalDocument(): string
    {
        return $this->legalDocument;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getSector(): string
    {
        return $this->sector;
    }

}