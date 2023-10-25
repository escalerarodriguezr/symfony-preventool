<?php
declare(strict_types=1);

namespace Preventool\Infrastructure\Ui\Http\Request\DTO\Process;

use Preventool\Infrastructure\Ui\Http\Request\RequestDTO;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UpdateActivityTaskRequest implements RequestDTO
{
    const NAME = 'name';
    const DESCRIPTION = 'description';

    #[NotBlank(
        message: 'Missing request parameter',
        allowNull: true
    )]
    #[Length(
        min: 2,
        max: 100,
        minMessage: 'Must be at least {{ limit }} characters long',
        maxMessage: 'Can not be longer than {{ limit }} characters',
    )]
    private mixed $name;

    #[NotBlank(
        message: "Invalid parameter 'description' can no be blank",
        allowNull: true
    )]
    private mixed $description;



    public function __construct(Request $request)
    {
        $payload = json_decode($request->getContent(),true);
        $this->name = $payload[self::NAME] ?? null;
        $this->description = $payload[self::DESCRIPTION] ?? null;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }


}