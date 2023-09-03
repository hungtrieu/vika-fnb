<?php

namespace App\Filament\Resources\AttendanceLogResource\Pages;

use App\Filament\Resources\AttendanceLogResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAttendanceLog extends CreateRecord
{
    protected static string $resource = AttendanceLogResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();
        
        $data['schedule_id'] = 0; // for simple business logic

        return $data;
    }
}
