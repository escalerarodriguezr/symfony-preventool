<?php
declare(strict_types=1);

namespace Preventool\Domain\Process\Repository;

use Preventool\Domain\Process\Model\ProcessActivityTask;
use Preventool\Domain\Shared\Model\Value\Uuid;

interface ProcessActivityTaskRepository
{
    public function save(ProcessActivityTask $processActivityTask): void;
    public function findById(Uuid $id):ProcessActivityTask;
    public function delete(ProcessActivityTask $processActivityTask): void;
    public function getAllByProcessActivityId(Uuid $processActivityId):array;

}