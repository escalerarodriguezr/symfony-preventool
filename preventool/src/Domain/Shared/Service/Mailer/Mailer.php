<?php
declare(strict_types=1);

namespace Preventool\Domain\Shared\Service\Mailer;

interface Mailer
{
    public function send(
        string $receiver,
        string $template,
        array $payload,
        ?string $sender=null
    ):void;

}