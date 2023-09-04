<?php

namespace App\Filament\Resources\AttendanceLogResource\Pages;

use App\Filament\Resources\AttendanceLogResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAttendanceLogs extends ListRecords
{
    protected static string $resource = AttendanceLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->mutateFormDataUsing(function (array $data): array {
                    $user = auth()->user();

                    $data['user_id'] = $user->id;

                    $data['store_id'] = $user->store_id;
        
                    $data['schedule_id'] = 0;

                    return $data;
                }),
        ];
    }
}
