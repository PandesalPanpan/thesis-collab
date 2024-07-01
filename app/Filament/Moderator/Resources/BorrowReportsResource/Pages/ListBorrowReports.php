<?php

namespace App\Filament\Moderator\Resources\BorrowReportsResource\Pages;

use App\Filament\Moderator\Resources\BorrowReportsResource;
use Closure;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Table;

class ListBorrowReports extends ListRecords
{
    protected static string $resource = BorrowReportsResource::class;

    protected function makeTable(): Table
    {
        return parent::makeTable()->recordUrl(null);
    }
    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
