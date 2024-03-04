<?php

namespace App\Filament\Moderator\Resources\ModeratorResource\Widgets;

use App\Models\Equipment;
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

class LatestBorrows extends BaseWidget
{
    protected static ?string $heading = 'Borrow Reports';
    protected int | string | array $columnSpan = 'full';
    public function table(Table $table): Table
    {
        return $table
            ->query(function (Activity $query){
                return $query
                    ->where('log_name', 'Borrow');
            })
            ->columns([
                TextColumn::make('properties.attributes.user_id')
                    ->label("Borrower")
                    ->formatStateUsing(function ($state){
                        if (!$state){
                            return '-';
                        }
                        $stateRecord = User::find($state);
                        return $stateRecord->name;
                    }),
                TextColumn::make('properties.old.name')
                    ->label('Equipment'),
                TextColumn::make('properties.attributes.borrow_date_start')
                    ->label('Date Borrowed')
                    ->formatStateUsing(function ($state){
                        if (!$state){
                            return '-';
                        }
                        $formatDate = Carbon::parse($state);
                        return $formatDate->format('F j, Y, h:i:s A');
                    }),
                TextColumn::make('properties.attributes.borrow_date_return_deadline')
                    ->label('Borrow Deadline')
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
                    ->trueLabel('This week')
                    ->falseLabel('All')
                    ->queries(
                        true: fn (Builder $query) => $query->whereDate('created_at', '>=', Carbon::now()->subWeek()),
                        false: fn (Builder $query) => $query,
                        blank: fn (Builder $query) => $query->whereDate('created_at', Carbon::today()),
                    )
            ])
            ->defaultSort('updated_at', 'desc');;
    }
}
