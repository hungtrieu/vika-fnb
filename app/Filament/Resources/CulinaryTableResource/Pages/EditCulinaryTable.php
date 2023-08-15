<?php

namespace App\Filament\Resources\CulinaryTableResource\Pages;

use App\Filament\Resources\CulinaryTableResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCulinaryTable extends EditRecord
{
    protected static string $resource = CulinaryTableResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
