<?php

namespace App\Filament\Moderator\Widgets;

use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Activitylog\Models\Activity;

class LatestReturns extends BaseWidget
{
    protected static ?string $heading = 'Returns Report';
    protected int | string | array $columnSpan = 'full';
    public function table(Table $table): Table
    {
        return $table
        ->query(function (Activity $query){
            $today = Carbon::today();
            return $query
                ->where('log_name', 'Returns');
            //return $query->where('log_name', 'Borrow');
        })
            ->columns([
                TextColumn::make('properties.old.user_id')
                    ->label("Returner")
                    ->formatStateUsing(function ($state){
                        if (!$state){
                            return '-';
                        }
                        $stateRecord = User::find($state);
                        return $stateRecord->name;
                    }),
                TextColumn::make('properties.old.name')
                    ->label('Equipment'),
                TextColumn::make('properties.attributes.borrow_last_returned')
                    ->label('Date Returned')
                    ->formatStateUsing(function ($state){
                        if (!$state){
                            return '-';
                        }
                        $formatDate = Carbon::parse($state);
                        return $formatDate->format('F j, Y, h:i:s A');
                    }),
            ])
            ->filters([
                TernaryFilter::make('Date range')
                    ->placeholder('Today')
                    ->trueLabel('Week')
                    ->falseLabel('All')
                    ->queries(
                        true: fn (Builder $query) => $query->whereDate('created_at', '>=', Carbon::now()->subWeek()),
                        false: fn (Builder $query) => $query,
                        blank: fn (Builder $query) => $query->whereDate('created_at', Carbon::today()),
                    )
            ])
            ->defaultSort('updated_at', 'desc');;;
    }
}
