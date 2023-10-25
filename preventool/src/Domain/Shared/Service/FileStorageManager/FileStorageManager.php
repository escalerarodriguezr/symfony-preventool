<?php
declare(strict_types=1);

namespace Preventool\Domain\Shared\Service\FileStorageManager;

use Symfony\Component\HttpFoundation\File\UploadedFile;

interface FileStorageManager
{
    const VISIBILITY_PUBLIC = 'public';
    const VISIBILITY_PRIVATE = 'private';

    public function uploadFile(
        UploadedFile $file,
        string $prefix,
        string $visibility
    ): string;

    public function deleteFile(?string $path): void;

    /**
     * @param string $path
     * @return resource
     */
    public function readFile ( string $path);
    public function readTempUrl ( string $path, int $seconds): string;

}