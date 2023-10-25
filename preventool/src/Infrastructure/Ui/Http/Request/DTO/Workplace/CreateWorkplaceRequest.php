<?php
declare(strict_types=1);

namespace Preventool\Infrastructure\Ui\Http\Request\DTO\Workplace;

use Preventool\Infrastructure\Ui\Http\Request\RequestDTO;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class CreateWorkplaceRequest implements RequestDTO
{

    const NAME = 'name';
    const CONTACT_PHONE = 'contactPhone';

    const ADDRESS = 'address';
    const NUMBER_OF_WORKERS = 'numberOfWorkers';



    /**
     * @Assert\NotBlank(message = "Missing or invalid request parameter 'name'.")
     * @Assert\Type(
     *     type="string",
     *     message = "Invalid value of request parameter 'name'."
     * )
     */
    private mixed $name;

    /**
     * @Assert\NotBlank(message = "Missing or invalid request parameter 'contactPhone'.")
     * @Assert\Type(
     *     type="string",
     *     message = "Invalid value of request parameter 'contactPhone'."
     * )
     */
    private mixed $contactPhone;


    /**
     * @Assert\NotBlank(message = "Missing or invalid request parameter 'address'.")
     * @Assert\Type(
     *     type="string",
     *     message = "Invalid value of request parameter 'address'."
     * )
     */
    private mixed $address;


    /**
     * @Assert\NotBlank(message = "Missing or invalid request parameter 'numberOfWorkers'.")
     * @Assert\Type(
     *     type="integer",
     *     message = "The value {{ value }} is not a valid {{ type }}."
     * )
     */
    private mixed $numberOfWorkers;


    public function __construct(
        Request $request
    )
    {
        $payload = $request->toArray();

        $this->name = $payload[self::NAME] ?? null;
        $this->contactPhone = $payload[self::CONTACT_PHONE] ?? null;
        $this->address = $payload[self::ADDRESS] ?? null;
        $this->numberOfWorkers = $payload[self::NUMBER_OF_WORKERS] ?? null;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getContactPhone(): string
    {
        return $this->contactPhone;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getNumberOfWorkers(): int
    {
        return $this->numberOfWorkers;
    }

}