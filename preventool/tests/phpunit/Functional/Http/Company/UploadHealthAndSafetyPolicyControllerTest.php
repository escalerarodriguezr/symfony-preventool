<?php
declare(strict_types=1);

namespace PHPUnit\Tests\Functional\Http\Company;

use PHPUnit\Tests\Functional\Http\FunctionalHttpTestBase;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\AdminFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\CompanyFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\HealthAndSafetyPolicyFixtures;
use Preventool\Infrastructure\Persistence\Doctrine\DataFixtures\UserFixtures;
use Preventool\Infrastructure\Ui\Http\Request\DTO\Company\UploadHealthAndSafetyPolicyRequest;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UploadHealthAndSafetyPolicyControllerTest extends FunctionalHttpTestBase
{
    const END_POINT = 'api/v1/company/%s/upload-health-and-safety-policy';

    public function setUp(): void
    {
        parent::setUp();
    }

    private function prepareDatabase(): void
    {
        $this->databaseTool->loadFixtures([
            UserFixtures::class,
            AdminFixtures::class,
            CompanyFixtures::class,
            HealthAndSafetyPolicyFixtures::class
        ]);
    }

    public function testUploadHealthAndSafetyPolicySuccessResponse(): void
    {
        $this->prepareDatabase();
        $this->authenticatedRootClient();

        $file = new UploadedFile(
            __DIR__.'/pdfPlaceholder.pdf',
            'pdfPlaceholder.png'
        );

        self::$authenticatedRootClient->request(
            Request::METHOD_POST,
            sprintf(
                self::END_POINT,
                CompanyFixtures::RIVENDEL_UUID
            ),
            [],
            [UploadHealthAndSafetyPolicyRequest::FILE_INPUT => $file]

        );

        $response = self::$authenticatedRootClient->getResponse();
        self::assertEquals(
            Response::HTTP_OK,
            $response->getStatusCode()
        );

        $query = sprintf(
            'SELECT id, document_resource FROM health_and_safety_policy WHERE company_id = "%s"',
            CompanyFixtures::RIVENDEL_UUID
        );
        $policy = self::initDBConnection()->executeQuery($query)->fetchAssociative();

        self::assertStringEndsWith(
            '.pdf',
            $policy['document_resource']
        );

    }

    public function testUnprocessableEntityHttpExceptionResponse(): void
    {
        $this->prepareDatabase();
        $this->authenticatedRootClient();

        $file = new UploadedFile(
            __DIR__.'/fake.txt',
            'fake.txt'
        );

        self::$authenticatedRootClient->request(
            Request::METHOD_POST,
            sprintf(
                self::END_POINT,
                CompanyFixtures::RIVENDEL_UUID
            ),
            [],
            [UploadHealthAndSafetyPolicyRequest::FILE_INPUT => $file]

        );

        $response = self::$authenticatedRootClient->getResponse();
        self::assertEquals(
            Response::HTTP_UNPROCESSABLE_ENTITY,
            $response->getStatusCode()
        );

    }




}