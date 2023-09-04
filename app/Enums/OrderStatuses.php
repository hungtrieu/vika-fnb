<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;
 
enum OrderStatuses: int implements HasLabel
{
    case Received = 1;
    case Cooking = 2;
    case Prepared = 3;
    case Served = 4;
    case Paid = 5;
    case Completed = 10;
    case Canceled = 99;
    
    public function getLabel(): ?string
    {
        return $this->name;
        
        // or
    
        return match ($this) {
            self::Received => 'Received',
            self::Cooking => 'Cooking',
            self::Prepared => 'Prepared',
            self::Served => 'Served',
            self::Paid => 'Paid',
            self::Completed => 'Completed',
            self::Canceled => 'Canceled',
        };
    }
}