<?php
declare(strict_types=1);

namespace Preventool\Application\Demo\CreateDemo;

use ContainerYqd0x1b\getMessenger_Middleware_RejectRedeliveredMessageMiddlewareService;
use Preventool\Domain\Demo\DomainEvent\DemoCreated;
use Preventool\Domain\Demo\Model\Demo;
use Preventool\Domain\Demo\Repository\DemoRepository;
use Preventool\Domain\Shared\Bus\Command\CommandHandler;
use Preventool\Domain\Shared\Bus\DomainEvent\DomainEventBus;
use Preventool\Domain\Shared\Model\IdentityGenerator;

class CreateDemoCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly DomainEventBus $domainEventBus,
        private readonly DemoRepository $demoRepository,
        private readonly IdentityGenerator $identityGenerator
    )
    {
    }


    public function __invoke(
        CreateDemoCommand $command
    ):void
    {
//        dd(
//            "desde el handler",
//            $command
//        );

        $demo = new Demo(
            $this->identityGenerator->generateId(),
            $command->name
        );
        $this->demoRepository->save($demo);

//        $demo = $this->demoRepository->findById('id_1');
//
//       $this->demoRepository->remove($demo);
//        throw new \Exception("jksdfhjksd");

        $event = new DemoCreated(
            $demo->getId()
        );

        $this->domainEventBus->dispatch($event);

    }


}