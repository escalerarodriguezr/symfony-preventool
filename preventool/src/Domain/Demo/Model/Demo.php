<?php
declare(strict_types=1);

namespace Preventool\Domain\Demo\Model;

use Preventool\Domain\Shared\Model\AggregateRoot;

class Demo extends AggregateRoot
{

    public function __construct(
        private string $id,
        private string $name
    )
    {
        parent::__construct();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }


}