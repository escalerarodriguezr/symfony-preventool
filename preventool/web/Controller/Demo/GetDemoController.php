<?php
declare(strict_types=1);

namespace App\Controller\Demo;

use Preventool\Application\Demo\CreateDemo\CreateDemoCommand;
use Preventool\Application\Demo\GetUserById\GetDemoByIdQuery;
use Preventool\Domain\Shared\Bus\Command\CommandBus;
use Preventool\Domain\Shared\Bus\Query\QueryBus;
use Preventool\Domain\Shared\Model\IdentityValidator;
use Preventool\Infrastructure\Ui\Http\Request\DTO\CreateDemoRequest;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class GetDemoController
{


    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly CommandBus $commandBus,
        private readonly QueryBus $queryBus,
        private readonly IdentityValidator $identityValidator
    )
    {
    }

    public function __invoke(CreateDemoRequest $createDemoRequest):Response
    {

//        $this->identityValidator->validate("rafa");
//
//        $query = new GetDemoByIdQuery(
//            'rafa'
//        );
//
//        $response = $this->queryBus->handle($query);
//
//        dd($response);



        $command = new CreateDemoCommand(
            $createDemoRequest->getName(),
            $createDemoRequest->getWidth(),
            $createDemoRequest->getHeight()
        );

        $this->commandBus->dispatch($command);



        return new JsonResponse(null,200);
    }


}