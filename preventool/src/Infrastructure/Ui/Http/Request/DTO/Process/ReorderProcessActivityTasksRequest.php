<?php
declare(strict_types=1);

namespace Preventool\Infrastructure\Ui\Http\Request\DTO\Process;

use Preventool\Infrastructure\Ui\Http\Request\RequestDTO;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\All;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Uuid;

class ReorderProcessActivityTasksRequest implements RequestDTO
{
    const ORDER = 'order';

    #[NotBlank(
        message: "Missing request parameter"
    )]
    #[All([
        new NotBlank(message: "Missing order array item"),
        new Uuid(message: 'Invalid Uuid')
    ])]
    private mixed $order;

    public function __construct(Request $request)
    {
        $payload = json_decode($request->getContent(),true);
        $this->order = $payload[self::ORDER] ?? null;
    }

    /**
     * @return string[]
     */
    public function getOrder(): array
    {
        return $this->order;
    }


}