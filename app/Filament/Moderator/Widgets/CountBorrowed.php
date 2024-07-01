<?php

namespace App\Filament\Moderator\Widgets;

use App\Models\Equipment;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class CountBorrowed extends BaseWidget
{
    protected static ?int $sort = -3;
    protected int | string | array $columnSpan = '1';
    protected function getStats(): array
    {
        return [
            Stat::make('Currently Borrowed', Equipment::whereNotNull('user_id')->count()),
        ];
    }
}
