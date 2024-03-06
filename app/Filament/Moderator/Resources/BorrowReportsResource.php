<?php

namespace App\Filament\Moderator\Resources;

use App\Filament\Moderator\Resources\BorrowReportsResource\Pages;
use App\Filament\Moderator\Resources\BorrowReportsResource\RelationManagers;
use App\Models\BorrowReports;
use App\Models\User;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\QueryBuilder\Constraints\TextConstraint;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Spatie\Activitylog\Models\Activity;

class BorrowReportsResource extends Resource
{
    protected static ?string $model = Activity::class;
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?string $navigationLabel = 'Borrow Reports';
    protected static ?string $modelLabel = 'Borrow Reports';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->query(function (Activity $query){
            return $query
                ->where(function ($subQuery) {
                    $subQuery->where('event', 'return')
                        ->orWhere('event', 'borrow');
                });
        })
            ->columns([
                TextColumn::make('event')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'borrow' => 'info',
                        'return' => 'success',
                    }),
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
                TextColumn::make('properties.attributes.borrow_purpose')
                    ->label('Borrow Purpose')
                    ->wrap(),
                TextColumn::make('properties.attributes.noted_instructor')
                    ->label('Noted Instructor'),
                TextColumn::make('properties.attributes.borrow_date_start')
                    ->label('Date Borrowed')
                    ->formatStateUsing(function ($state){
                        if (!$state){
                            return '-';
                        }
                        $formatDate = Carbon::parse($state);
                        return $formatDate->format('F j, Y, h:i:s A');
                    })
                    ->wrap(),
                TextColumn::make('properties.attributes.borrow_last_returned')
                    ->label('Returned Date')
                    ->formatStateUsing(function ($state){
                        if (!$state){
                            return '-';
                        }
                        $formatDate = Carbon::parse($state);
                        return $formatDate->format('F j, Y, h:i:s A');
                    })
                    ->wrap(),
                TextColumn::make('properties.attributes.borrow_date_return_deadline')
                    ->label('Borrow Deadline')
                    ->formatStateUsing(function ($state){
                        if (!$state){
                            return '-';
                        }
                        $formatDate = Carbon::parse($state);
                        return $formatDate->format('F j, Y, h:i:s A');
                    })
                    ->wrap(),
                TextColumn::make('causer.name')
                    ->label('Handled By'),
                TextColumn::make('batch_uuid')
                    ->label('Batch UUID (Searchable)')
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Copied')
                    ->copyMessageDuration(1500),
                TextColumn::make('created_at')
                    ->label('Report Created At (Searchable)')
                    ->sortable()
                    ->searchable()
            ])
            ->filters([

            ])
            ->actions([
                //Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ])
            ->defaultSort('created_at', 'desc');;
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBorrowReports::route('/'),
            // 'create' => Pages\CreateBorrowReports::route('/create'),
            // 'edit' => Pages\EditBorrowReports::route('/{record}/edit'),
        ];
    }
    public static function canCreate(): bool 
    {
       return false;
    }
}
