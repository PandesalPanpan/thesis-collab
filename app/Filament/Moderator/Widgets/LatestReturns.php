<?php

namespace App\Filament\Moderator\Widgets;

use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Spatie\Activitylog\Models\Activity;

class LatestReturns extends BaseWidget
{
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
                        //ddd($state);
                        // The issue is, it still gets the properties despite
                        // Find the user id instead
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
                        $formatDate = new DateTime($state);
                        return $formatDate->format('F j, Y, h:i:s A');
                    }),
            ]);
    }
}
