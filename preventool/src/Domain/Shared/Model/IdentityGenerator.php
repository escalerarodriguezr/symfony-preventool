<?php
declare(strict_types=1);

namespace Preventool\Domain\Shared\Model;

interface IdentityGenerator
{
    public function generateId(): string;

}