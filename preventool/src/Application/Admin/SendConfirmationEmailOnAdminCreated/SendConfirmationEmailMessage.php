<?php
declare(strict_types=1);

namespace Preventool\Application\Admin\SendConfirmationEmailOnAdminCreated;

use Preventool\Domain\Shared\Bus\Message\Message;

class SendConfirmationEmailMessage implements Message
{


    public function __construct(
        public readonly string $adminId
    )
    {
    }
}