<?php

namespace App\Filament\Resources\CulinaryTableResource\Pages;

use App\Filament\Resources\CulinaryTableResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCulinaryTables extends ListRecords
{
    protected static string $resource = CulinaryTableResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
