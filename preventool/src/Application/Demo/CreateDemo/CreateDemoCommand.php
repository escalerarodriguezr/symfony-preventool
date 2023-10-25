<?php
declare(strict_types=1);

namespace Preventool\Application\Demo\CreateDemo;

use ContainerDNqGRSx\getRedirectControllerService;
use Preventool\Domain\Shared\Bus\Command\Command;

class CreateDemoCommand implements Command
{
    public function __construct(
        public readonly string $name,
        public readonly int $width,
        public readonly int $height,
        public readonly int $numberOfRandomBlocks = 0
    )
    {
    }


}