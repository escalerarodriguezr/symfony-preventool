<?php
declare(strict_types=1);

namespace Preventool\Infrastructure\Ui\Http\Request\DTO\Process;

use Preventool\Infrastructure\Ui\Http\Request\RequestDTO;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UpdateProcessRequest implements RequestDTO
{
    const NAME = 'name';
    const DESCRIPTION = 'description';

    #[NotBlank(
        message: "Missing request parameter 'name'",
        allowNull: true
    )]
    #[Length(
        min: 2,
        max: 100,
        minMessage: 'Name must be at least {{ limit }} characters long',
        maxMessage: 'Name cannot be longer than {{ limit }} characters',
    )]
    private mixed $name;

    #[NotBlank(
        message: "Invalid request parameter 'description' can not be blank.",
        allowNull: true
    )]
    private mixed $description;

    public function __construct(Request $request)
    {
        $payload = $request->toArray();
        $this->name = $payload[self::NAME] ?? null;
        $this->description = $payload[self::DESCRIPTION] ?? null;
    }


    public function getName(): ?string
    {
        return $this->name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }



}