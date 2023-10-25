<?php
declare(strict_types=1);

namespace Preventool\Domain\Shared\Model;

interface IdentityValidator
{
    public function validate(string $id): void;

}