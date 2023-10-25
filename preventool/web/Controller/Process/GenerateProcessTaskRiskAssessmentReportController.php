<?php
declare(strict_types=1);

namespace App\Controller\Process;


use DateTimeZone;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Knp\Snappy\Pdf;
use Preventool\Domain\Process\Repository\ProcessRepository;
use Preventool\Domain\Shared\Model\IdentityValidator;
use Preventool\Domain\Shared\Model\Value\Uuid;
use Twig\Environment;

class GenerateProcessTaskRiskAssessmentReportController
{

    public function __construct(
        private readonly Pdf $knpSnappyPdf,
        private readonly Environment $engine,
        private readonly IdentityValidator $identityValidator,
        private readonly ProcessRepository $processRepository
    )
    {
    }

    public function __invoke(
        string $processId,
        string $type

    )
    {

        $this->identityValidator->validate($processId);

        $process = $this->processRepository->findById(new Uuid($processId));
        $workplace = $process->getWorkplace();
        $company = $workplace->getCompany();
        $activities = $process->getProcessActivities();

//        $tasks = $activities[0]->getActivityTasks();
//
////        $hazards = $tasks[0]->ge




//        $reportDate = new \DateTime();
//        //TimeZone de la impresión
//        $reportDate->setTimezone(new DateTimeZone('America/Lima'));

        $reportDate = new \DateTimeImmutable();

        $header = 'report/process/risk-assessment/header.pdf.twig';
        $footer = 'report/process/risk-assessment/footer.pdf.twig';

        $header = $this->engine->render($header,[
                'companyName' => $company->getName()->value,
                'workplaceName' => $workplace->getName()->value,
                'processRevision' => $process->getRevisionNumber(),
                'reportDate' => $reportDate->format('Y-m-d H:i:s')
            ]
        );
        $footer = $this->engine->render($footer);

        if ($type === 'general'){
            $template = 'report/process/risk-assessment/report-general.pdf.twig';
        }

        if ($type === 'process-resume'){
            $template = 'report/process/risk-assessment/report-process-resume.pdf.twig';
        }


        $html = $this->engine->render($template,[
            'processName' => $process->getName()->value,
            'processDescription' => $process->getDescription()?->decodeValue(),
            'numberOfActivities' => $activities->count(),
            'activities' => $activities
        ]);


        $options = [
            'title' => 'Informe',
            'encoding' => 'utf-8',
            'header-html' => $header,
            'margin-top' => '20mm',
            'margin-bottom' => '15mm',
            'footer-html' => $footer,
            'footer-right' => '[page] de [toPage]'
        ];

        return new PdfResponse(
            $this->knpSnappyPdf->getOutputFromHtml($html,$options),
            'file.pdf'
        );

    }


}