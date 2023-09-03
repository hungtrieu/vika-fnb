<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;
 
enum AttendanceType: int implements HasLabel
{
    case CheckIn = 1;
    case CheckOut = 2;
    
    public function getLabel(): ?string
    {
        return $this->name;
        
        // or
    
        return match ($this) {
            self::CheckIn => 'Check-in',
            self::CheckOut => 'Check-out',
        };
    }
}