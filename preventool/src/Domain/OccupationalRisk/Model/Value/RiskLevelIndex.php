<?php
declare(strict_types=1);

namespace Preventool\Domain\OccupationalRisk\Model\Value;

use Assert\Assertion;
use Assert\AssertionFailedException;

class RiskLevelIndex
{

    public function __construct(
        public readonly int $value
    )
    {
        try {
            Assertion::integer($value);
            Assertion::between($value, 4, 36);
        } catch(AssertionFailedException $e) {
            throw new \DomainException(sprintf('"Value %d must be integer between 4 and 36', $value));
        }

    }

    public function description():string{
       if( $this->value <= 4 ){
           return 'Trivial';
       }else if( $this->value >=5 && $this->value<= 8 ){
           return 'Tolerable';
       }else if( $this->value >= 9 && $this->value <= 16 ){
           return 'Moderado';
       }else if ( $this->value >= 17 && $this->value <= 24 ){
           return 'Importante';
       }else if ( $this->value >= 25 && $this->value <= 36 ){
           return 'Intolerable';
       }else{
           return '';
       }

    }



}