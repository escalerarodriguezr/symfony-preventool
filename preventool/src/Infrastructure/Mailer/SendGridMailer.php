<?php
declare(strict_types=1);

namespace Preventool\Infrastructure\Mailer;

use Preventool\Domain\Shared\Service\Mailer\Mailer;
use Psr\Log\LoggerInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Twig\Environment;

class SendGridMailer implements Mailer
{

    public const TEMPLATE_SUBJECT_MAP = [
        TwigTemplate::ADMIN_REGISTER => 'Bienvenido a Preventool!',
    ];

    public function __construct(
        private readonly MailerInterface $mailer,
        private readonly Environment $engine,
        private readonly LoggerInterface $logger,
        private readonly string $defaultSender
    )
    {
    }

    public function send(
        string $receiver,
        string $template,
        array $payload,
        ?string $sender = null
    ): void
    {
        $email = (new Email())
            ->from(!empty($sender) ? $sender : $this->defaultSender)
            ->to($receiver)
            ->subject(self::TEMPLATE_SUBJECT_MAP[$template])
            ->html($this->engine->render($template, $payload));

        try {
            $this->mailer->send($email);
            $this->logger->info(sprintf('Email sent to %s', $receiver));
        } catch (TransportExceptionInterface $e) {
            $this->logger->error(sprintf('Error sending email sent to %s. Error message: %s', $receiver, $e->getMessage()));
        }
    }


}