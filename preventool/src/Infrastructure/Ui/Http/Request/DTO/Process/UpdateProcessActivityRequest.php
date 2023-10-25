<?php
declare(strict_types=1);

namespace Preventool\Infrastructure\Ui\Http\Request\DTO\Process;

use Preventool\Infrastructure\Ui\Http\Request\RequestDTO;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UpdateProcessActivityRequest implements RequestDTO
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

    private mixed $description;


    public function __construct(Request $request)
    {
        $payload = json_decode($request->getContent(),true);
        $this->name = $payload[self::NAME] ?? null;
        $this->description = $payload[self::DESCRIPTION] ?? null;
        $this->description = empty($this->description) ? null : $this->description;
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