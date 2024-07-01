<?php

namespace App\Filament\Moderator\Resources\BorrowReportsResource\Pages;

use App\Filament\Moderator\Resources\BorrowReportsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBorrowReports extends EditRecord
{
    protected static string $resource = BorrowReportsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
