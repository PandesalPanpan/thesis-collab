<?php

namespace App\Filament\Moderator\Resources\LogResource\Pages;

use App\Filament\Moderator\Resources\LogResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLogs extends ListRecords
{
    protected static string $resource = LogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
