<?php
declare(strict_types=1);

namespace Preventool\Infrastructure\FileStorage;


use DateInterval;
use League\Flysystem\FilesystemException;
use League\Flysystem\FilesystemOperator;
use League\Flysystem\UnableToReadFile;
use Monolog\DateTimeImmutable;
use Preventool\Domain\Shared\Service\FileStorageManager\FileStorageManager;
use Psr\Log\LoggerInterface;
use Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class DigitalOceanFileStorageManager implements FileStorageManager
{

   const COMPANY_HEALTH_SAFTEY_POLICY = 'company_health_saftey_policy/%s'; // %s=companyId

    public function __construct(
        private readonly FilesystemOperator $defaultStorage,
        private readonly LoggerInterface $logger,
        private readonly string $projectDigitalOceanStoragePath
    )
    {


    }


    public function uploadFile(
        UploadedFile $file,
        string $prefix,
        string $visibility
    ): string
    {

        $fileIdentifier = \sha1(\uniqid());
        $fileName = \sprintf(
            '%s%s/%s.%s',
            $this->projectDigitalOceanStoragePath,
            $prefix,
            $fileIdentifier,
            $file->guessExtension()
        );

        try{
            $this->defaultStorage->writeStream(
                $fileName,
                \fopen($file->getPathname(), 'r'),
                ['visibility' => $visibility]
            );

        }catch (\Exception $e){
            $this->logger->warning("Error uploading file");
            throw new IOException('Error uploading file');
        }

        return sprintf('%s.%s', $fileIdentifier,$file->guessExtension());
    }

    public function deleteFile(
        ?string $path
    ): void
    {
        try {
            if (null !== $path) {
                $this->defaultStorage->delete(
                    sprintf('%s%s',
                        $this->projectDigitalOceanStoragePath,
                        $path
                    )
                );
            }
        } catch (\Exception $e) {
            $this->logger->warning(\sprintf('File %s not found in the storage', $path));
            throw new IOException(\sprintf('File %s not found in the storage', $path));
        }
    }

    public function readFile(string $path): mixed
    {
        try {
            $response = $this->defaultStorage->readStream($path);
            return $response;
        } catch (FilesystemException | UnableToReadFile $exception) {
            $this->logger->warning(\sprintf('File %s not found in the storage', $path));
            throw new IOException(\sprintf('File %s not found in the storage', $path));
        }
    }

    public function readTempUrl(string $path, int $seconds): string
    {

        try {
            $expiredAt = new \DateTimeImmutable();
            $interval = new DateInterval(
                sprintf('PT%dS', $seconds)
            );
            $duration = $expiredAt->add($interval);
            return $this->defaultStorage->temporaryUrl($path, $duration);

        } catch (\Exception $e) {
            $this->logger->warning(\sprintf('File %s not found in the storage', $path));
            throw new IOException(\sprintf('File %s not found in the storage', $path));
        }

    }


}