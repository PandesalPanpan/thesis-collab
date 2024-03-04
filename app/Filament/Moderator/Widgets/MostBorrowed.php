<?php

namespace App\Filament\Moderator\Widgets;

use App\Models\Equipment;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class MostBorrowed extends BaseWidget
{
    protected static ?string $heading = "Equipment Popularity";
    protected int | string | array $columnSpan = 'full';
    public function table(Table $table): Table
    {
        return $table
            ->query(
                Equipment::query()
            )
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('borrowed_count')
                    ->sortable(),
            ])
            ->defaultSort('borrowed_count', 'desc');;
    }
}
