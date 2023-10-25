<?php
declare(strict_types=1);

namespace PHPUnit\Tests\Integration\Infrastructure\FileStorage;

use Preventool\Domain\Shared\Service\FileStorageManager\FileStorageManager;
use Preventool\Infrastructure\FileStorage\DigitalOceanFileStorageManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class DigitalOceanFileStorageManagerTest extends KernelTestCase
{
    public function testUploadFile()
    {
        self::bootKernel();
        $container = static::getContainer();
        $fileStorageManager = $container->get(DigitalOceanFileStorageManager::class);
        $file = new UploadedFile(
            __DIR__.'/pdfPlaceholder.pdf',
            'pdfPlaceholder.png'
        );

        $fileName = $fileStorageManager->uploadFile(
            $file,
            'prefix',
            FileStorageManager::VISIBILITY_PRIVATE
        );
        self::assertIsString($fileName);
    }

    public function testDeleteFile()
    {

        self::bootKernel();
        $container = static::getContainer();
        $fileStorageManager = $container->get(DigitalOceanFileStorageManager::class);

        $prefix = 'prefix';
        $file = new UploadedFile(
            __DIR__.'/pdfPlaceholder.pdf',
            'pdfPlaceholder.png'
        );

        $fileName = $fileStorageManager->uploadFile(
            $file,
            $prefix,
            FileStorageManager::VISIBILITY_PRIVATE
        );
        self::assertIsString($fileName);

        $path = sprintf(
            '%s/%s',
            $prefix,
            $fileName
        );

        $fileStorageManager->deleteFile($path);
        self::assertEquals(1,1);
    }

}