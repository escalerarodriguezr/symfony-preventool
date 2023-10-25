<?php
declare(strict_types=1);

namespace Preventool\Domain\Process\Model\Value;

use Assert\Assertion;
use Assert\AssertionFailedException;

class ActivityTaskDescription
{
    public function __construct(
        private string $value,
        private bool $encode = true
    )
    {
        try{
            Assertion::minLength($this->value,1);
            if($this->encode){
                $this->value = base64_encode($this->value);
            }

        }catch (AssertionFailedException $exception){
            throw new \DomainException(sprintf('Description must be %d characters maximum',  1));
        }
    }



    public function value(): string
    {
        return $this->value;
    }

    public function decodeValue(): string
    {
        return base64_decode($this->value);
    }
    
}