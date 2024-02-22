<?php

namespace App\Filament\Tables\Columns;

use Filament\Tables\Columns\TextColumn as BaseTextColumn;

class PermissionColumn extends BaseTextColumn
{
    public function getDisplayValue($record)
    {
        return $record->status == 1 ? 'Permission Granted' : 'Permission Denied';
    }
}
