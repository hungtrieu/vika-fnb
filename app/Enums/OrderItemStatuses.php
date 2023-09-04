<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;
 
enum OrderItemStatuses: int implements HasLabel
{
    case Received = 1;
    case Cooking = 2;
    case Prepared = 3;
    case Served = 4;
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
            self::Canceled => 'Canceled',
        };
    }
}