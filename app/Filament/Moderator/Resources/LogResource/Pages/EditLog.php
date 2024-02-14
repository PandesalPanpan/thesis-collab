<?php

namespace App\Filament\Moderator\Resources\LogResource\Pages;

use App\Filament\Moderator\Resources\LogResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLog extends EditRecord
{
    protected static string $resource = LogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
