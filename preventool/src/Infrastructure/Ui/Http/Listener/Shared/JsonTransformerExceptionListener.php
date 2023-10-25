<?php
declare(strict_types=1);

namespace Preventool\Infrastructure\Ui\Http\Listener\Shared;

use Preventool\Domain\Admin\Exception\AdminAlreadyExistsException;
use Preventool\Domain\Admin\Exception\AdminInvalidCurrentPasswordException;
use Preventool\Domain\Admin\Exception\AdminNotFoundException;
use Preventool\Domain\Audit\Exception\AuditTypeAlreadyExistsException;
use Preventool\Domain\Audit\Exception\AuditTypeNotFoundException;
use Preventool\Domain\Audit\Exception\CreateAuditTypeCommandInvalidCommandException;
use Preventool\Domain\BaselineStudy\Exception\BaselineStudyAlreadyExistsException;
use Preventool\Domain\BaselineStudy\Exception\BaselineStudyComplianceOfWorkplaceAlreadyExistsException;
use Preventool\Domain\BaselineStudy\Exception\BaselineStudyNotFoundException;
use Preventool\Domain\BaselineStudy\Exception\WorkplaceBaselineStudyByCategoryNotFoundException;
use Preventool\Domain\Company\Exception\CompanyAlreadyExistsException;
use Preventool\Domain\Company\Exception\CompanyNotFoundException;
use Preventool\Domain\Company\Exception\DocumentHealthAndSafetyPolicyOfCompanyNotFoundException;
use Preventool\Domain\Company\Exception\HealthAndSafetyPolicyOfCompanyNotFoundException;
use Preventool\Domain\Company\Exception\HealthAndSafetyPolicyOfCompanyNotHasDocumentAssignedException;
use Preventool\Domain\OccupationalRisk\Exception\TaskHazardAlreadyExitsException;
use Preventool\Domain\OccupationalRisk\Exception\TaskHazardConflictException;
use Preventool\Domain\OccupationalRisk\Exception\TaskHazardNotFoundException;
use Preventool\Domain\OccupationalRisk\Exception\TaskRiskAssessmentAlreadyExitsException;
use Preventool\Domain\OccupationalRisk\Exception\TaskRiskAssessmentNotFoundException;
use Preventool\Domain\OccupationalRisk\Exception\TaskRiskNotFoundException;
use Preventool\Domain\Process\Exception\ProcessActivityAlreadyExistsException;
use Preventool\Domain\Process\Exception\ProcessActivityNotFoundException;
use Preventool\Domain\Process\Exception\ProcessActivityTaskAlreadyExistsException;
use Preventool\Domain\Process\Exception\ProcessActivityTaskNotFoundException;
use Preventool\Domain\Process\Exception\ProcessAlreadyExistsException;
use Preventool\Domain\Process\Exception\ProcessNotFoundException;
use Preventool\Domain\Shared\Exception\ActionNotAllowedException;
use Preventool\Domain\User\Exception\UserAccountNotActiveException;
use Preventool\Domain\User\Exception\UserAlreadyExistsException;
use Preventool\Domain\User\Exception\UserNotFoundException;
use Preventool\Domain\Workplace\Exception\WorkplaceAlreadyExistsException;
use Preventool\Domain\Workplace\Exception\WorkplaceNotBelongToCompanyException;
use Preventool\Domain\Workplace\Exception\WorkplaceNotFoundException;
use Preventool\Domain\WorkplaceHazard\Exception\WorkplaceHazardAlreadyExistsException;
use Preventool\Domain\WorkplaceHazard\Exception\WorkplaceHazardCategoryAlreadyExistsException;
use Preventool\Domain\WorkplaceHazard\Exception\WorkplaceHazardNotFoundException;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class JsonTransformerExceptionListener
{
    const ERRORS_KEY = 'errors';
    const CLASS_KEY = 'class';
    const CODE_KEY = 'code';
    const MESSAGE_KEY = 'message';

    public function __construct(
        private readonly LoggerInterface $logger
    )
    {
    }


    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        if ($exception instanceof HandlerFailedException) {
            $exception = $exception->getPrevious();
        }
        
        if(!$exception instanceof NotFoundHttpException){
           $this->logger->error($exception);
        }

        $data = [
            self::CLASS_KEY => \get_class($exception),
            self::CODE_KEY => Response::HTTP_INTERNAL_SERVER_ERROR,
            self::MESSAGE_KEY => $exception->getMessage(),
        ];

        if (\in_array($data[self::CLASS_KEY], $this->getNotFoundExceptions(), true)) {
            $data[self::CODE_KEY] = Response::HTTP_NOT_FOUND;
        }

        if (\in_array($data[self::CLASS_KEY], $this->getDeniedExceptions(), true)) {
            $data[self::CODE_KEY] = Response::HTTP_FORBIDDEN;
        }

        if (\in_array($data[self::CLASS_KEY], $this->getConflictExceptions(), true)) {
            $data[self::CODE_KEY] = Response::HTTP_CONFLICT;
        }

        if ($exception instanceof UnprocessableEntityHttpException) {
            $data[self::ERRORS_KEY] = [];
            foreach ( json_decode($exception->getMessage()) as $key => $error ){
                $data[self::ERRORS_KEY][$key] = $error;
            }
        }

        if ($exception instanceof HttpExceptionInterface) {
            $data[self::CODE_KEY] = $exception->getStatusCode();
        }


        $event->setResponse($this->prepareResponse($data));

    }

    private function prepareResponse(array $data): JsonResponse
    {
        $response = new JsonResponse($data, $data[self::CODE_KEY]);
        $response->headers->set('X-Error-Code', (string) $data[self::CODE_KEY]);
        $response->headers->set('X-Server-Time', (string) \time());

        return $response;
    }

    private function getNotFoundExceptions(): array
    {
        return [
            UserNotFoundException::class,
            AdminNotFoundException::class,
            CompanyNotFoundException::class,
            WorkplaceNotFoundException::class,
            HealthAndSafetyPolicyOfCompanyNotFoundException::class,
            DocumentHealthAndSafetyPolicyOfCompanyNotFoundException::class,
            AuditTypeNotFoundException::class,
            ProcessNotFoundException::class,
            WorkplaceHazardNotFoundException::class,
            TaskRiskNotFoundException::class,
            TaskHazardNotFoundException::class,
            TaskRiskAssessmentNotFoundException::class
        ];
    }

    private function getConflictExceptions(): array
    {
        return [
            UserAlreadyExistsException::class,
            UserAccountNotActiveException::class,
            AdminAlreadyExistsException::class,
            ActionNotAllowedException::class,
            AdminInvalidCurrentPasswordException::class,
            CompanyAlreadyExistsException::class,
            WorkplaceAlreadyExistsException::class,
            WorkplaceNotBelongToCompanyException::class,
            HealthAndSafetyPolicyOfCompanyNotHasDocumentAssignedException::class,
            CreateAuditTypeCommandInvalidCommandException::class,
            AuditTypeAlreadyExistsException::class,
            BaselineStudyAlreadyExistsException::class,
            BaselineStudyNotFoundException::class,
            WorkplaceBaselineStudyByCategoryNotFoundException::class,
            BaselineStudyComplianceOfWorkplaceAlreadyExistsException::class,
            ProcessAlreadyExistsException::class,
            ProcessActivityAlreadyExistsException::class,
            ProcessActivityNotFoundException::class,
            ProcessActivityTaskAlreadyExistsException::class,
            ProcessActivityTaskNotFoundException::class,
            WorkplaceHazardCategoryAlreadyExistsException::class,
            WorkplaceHazardAlreadyExistsException::class,
            TaskHazardConflictException::class,
            TaskHazardAlreadyExitsException::class,
            TaskRiskAssessmentAlreadyExitsException::class
        ];
    }

    private function getDeniedExceptions(): array
    {
        return [
            AccessDeniedException::class,
//            ActionUserAccessDeniedException::class
        ];
    }

}