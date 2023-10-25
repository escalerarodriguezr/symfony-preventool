<?php
declare(strict_types=1);

namespace Preventool\Application\Admin\SendConfirmationEmailOnAdminCreated;

use Preventool\Domain\Admin\Repository\AdminRepository;
use Preventool\Domain\Shared\Bus\Message\MessageHandler;
use Preventool\Domain\Shared\Model\Value\Uuid;
use Preventool\Domain\Shared\Service\Mailer\Mailer;
use Preventool\Infrastructure\Mailer\TwigTemplate;


class SendConfirmationEmailMessageHandler implements MessageHandler
{


    public function __construct(
        private readonly AdminRepository $adminRepository,
        private readonly Mailer $mailer,
    )
    {
    }

    public function __invoke(
        SendConfirmationEmailMessage $message
    ): void
    {

        $admin = $this->adminRepository->findById(
            new Uuid($message->adminId)
        );
        $payload = [
            'name' => ucfirst($admin->getName()->value)
        ];

        $this->mailer->send(
            $admin->getEmail()->value,
            TwigTemplate::ADMIN_REGISTER,
            $payload
        );
    }

}